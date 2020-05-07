<?php

namespace App\Repository\Operation;

use App\Entity\Account;
use App\Entity\Identifiable;
use App\Entity\Person;
use App\Repository\BaseRepository;
use App\ValueObject\AccountCash;
use App\ValueObject\Collection\AccountCashCollection;
use App\ValueObject\Collection\AccountCollection;
use App\ValueObject\Collection\Operation\BaseOperationCollection;
use App\ValueObject\Collection\PersonCollection;
use App\ValueObject\Collection\PersonObligationCollection;
use App\ValueObject\PersonObligation;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationRepository extends BaseRepository
{
    /**
     * Returns an operation list.
     *
     * @param UserInterface $user
     *
     * @return BaseOperationCollection
     */
    public function findByUser(UserInterface $user): BaseOperationCollection
    {
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return new BaseOperationCollection(...$result);
    }

    /**
     * Calculates the sum of all the inflows for the accounts provided.
     *
     * @param AccountCollection $accounts
     *
     * @return AccountCashCollection
     */
    public function getAccountInflowSums(AccountCollection $accounts): AccountCashCollection
    {
        $accountInflowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('t.id as target_id, SUM(o.amount) as sum')
            ->leftJoin('o.target', 't')
            ->andWhere('o.target in (:accounts)')
            ->setParameter('accounts', $accounts->toArray())
            ->groupBy('o.target')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $targetId = $result['target_id'];
            $sum      = $result['sum'];
            $account  = $this->findById($accounts->toArray(), $targetId);
            /** @var Account|null $account */
            if ($account) {
                $accountInflowSums[] = new AccountCash($account, $sum);
            }
        }

        return new AccountCashCollection(...$accountInflowSums);
    }

    /**
     * Calculates the sum of all the outflows for the accounts provided.
     *
     * @param AccountCollection $accounts
     *
     * @return AccountCashCollection
     */
    public function getAccountOutflowSums(AccountCollection $accounts): AccountCashCollection
    {
        $accountOutflowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('s.id as source_id, SUM(o.amount) as sum')
            ->leftJoin('o.source', 's')
            ->andWhere('o.source in (:accounts)')
            ->setParameter('accounts', $accounts->toArray())
            ->groupBy('o.source')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $sourceId = $result['source_id'];
            $sum      = $result['sum'];
            $account  = $this->findById($accounts->toArray(), $sourceId);
            /** @var Account|null $account */
            if ($account) {
                $accountOutflowSums[] = new AccountCash($account, $sum);
            }
        }

        return new AccountCashCollection(...$accountOutflowSums);
    }

    /**
     * Calculates the sum of all the person obligations for the provided persons and the given operation type (debt or
     * loan).
     *
     * @param PersonCollection $persons
     * @param integer  $type
     *
     * @return PersonObligationCollection
     */
    public function getPersonObligations(PersonCollection $persons, int $type): PersonObligationCollection
    {
        $personObligations = [];

        $connection = $this->getEntityManager()->getConnection();
        $sql = <<< 'SQL'
SELECT person_id,
       SUM(amount) as sum
FROM operation
WHERE person_id IN (?)
      AND type = (?)
GROUP BY person_id
SQL;

        $personIds = $this->getIds($persons->toArray());
        $stmt      = $connection->executeQuery($sql, [$personIds, $type], [Connection::PARAM_INT_ARRAY]);
        foreach ($stmt->fetchAll() as $personObligation) {
            $personId = $personObligation['person_id'];
            $sum      = $personObligation['sum'];
            $person   = $this->findById($persons->toArray(), $personId);
            /** @var Person|null $person */
            if ($person) {
                $personObligations[] = new PersonObligation($person, $sum);
            }
        }

        return new PersonObligationCollection(...$personObligations);
    }

    /**
     * Returns an ID array for provided identifiable entities.
     *
     * @param Identifiable[] $entities
     *
     * @return integer[]
     */
    protected function getIds(array $entities): array
    {
        $ids = [];

        foreach ($entities as $entity) {
            if (!$entity instanceof Identifiable) {
                continue;
            }
            $ids[] = $entity->getId();
        }

        return $ids;
    }
}
