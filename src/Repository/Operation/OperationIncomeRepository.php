<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationIncome;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;

class OperationIncomeRepository extends BaseOperationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationIncome::class);
    }

    /**
     * Returns sum for all the incomes.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUserIncomeSum(UserInterface $user): int
    {
        $result = $this->createQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->andWhere('o.user = :user')
            ->andWhere('o.fund IS NULL')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();

        return $result ?? 0;
    }
}
