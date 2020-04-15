<?php

namespace App\Repository\Operation;

use App\Entity\Account;
use App\Entity\Identifiable;
use App\Entity\Operation\BaseOperation;
use App\Entity\Person;
use App\Repository\BaseRepository;
use App\ValueObject\AccountCash;
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
     * @return BaseOperation[]
     */
    public function findByUser(UserInterface $user): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * Calculates the sum of all the inflows for the accounts provided.
     *
     * @param Account[] $accounts
     *
     * @return AccountCash[]
     */
    public function getAccountInflowSums(array $accounts): array
    {
        $groupedInflows = [];

        $accountInflowSums = $this->createQueryBuilder('o')
            ->select('t.id as target_id, SUM(o.amount) as sum')
            ->leftJoin('o.target', 't')
            ->andWhere('o.target in (:accounts)')
            ->setParameter('accounts', $accounts)
            ->groupBy('o.target')
            ->getQuery()
            ->getResult();

        foreach ($accountInflowSums as $accountInflowSum) {
            $targetId         = $accountInflowSum['target_id'];
            $sum              = $accountInflowSum['sum'];
            $account          = $accounts[$targetId];
            $groupedInflows[] = new AccountCash($account, $sum);
        }

        return $groupedInflows;
    }

    /**
     * Calculates the sum of all the outflows for the accounts provided.
     *
     * @param Account[] $accounts
     *
     * @return AccountCash[]
     */
    public function getAccountOutflowSums(array $accounts): array
    {
        $groupedOutflows = [];

        $accountOutflowSums = $this->createQueryBuilder('o')
            ->select('s.id as source_id, SUM(o.amount) as sum')
            ->leftJoin('o.source', 's')
            ->andWhere('o.source in (:accounts)')
            ->setParameter('accounts', $accounts)
            ->groupBy('o.source')
            ->getQuery()
            ->getResult();

        foreach ($accountOutflowSums as $accountOutflowSum) {
            $sourceId          = $accountOutflowSum['source_id'];
            $sum               = $accountOutflowSum['sum'];
            $account           = $accounts[$sourceId];
            $groupedOutflows[] = new AccountCash($account, $sum);
        }

        return $groupedOutflows;
    }

    /**
     * Calculates the sum of all the person obligations for the provided persons and the given operation type (debt or
     * loan).
     *
     * @param Person[] $persons
     * @param integer  $type
     *
     * @return PersonObligation[]
     */
    public function getPersonObligations(array $persons, int $type): array
    {
        $groupedDebts = [];

        $connection = $this->getEntityManager()->getConnection();
        $sql = <<< 'SQL'
SELECT person_id,
       SUM(amount) as sum
FROM operation
WHERE person_id IN (?)
      AND type = (?)
GROUP BY person_id
SQL;

        $personIds = $this->getIds($persons);
        $stmt      = $connection->executeQuery($sql, [$personIds, $type], [Connection::PARAM_INT_ARRAY]);
        foreach ($stmt->fetchAll() as $personObligation) {
            $personId       = $personObligation['person_id'];
            $sum            = $personObligation['sum'];
            $person         = $persons[$personId];
            $groupedDebts[] = new PersonObligation($person, $sum);
        }

        return $groupedDebts;
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
