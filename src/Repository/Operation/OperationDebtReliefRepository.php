<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationDebtRelief;
use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;

class OperationDebtReliefRepository extends BaseOperationDebtRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationDebtRelief::class);
    }

    /**
     * Returns sum for the debt reliefs during the last 30 days.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getDebtReliefSum30Days(UserInterface $user): int
    {
        $result = $this->createQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->leftJoin('o.debt', 'd')
            ->andWhere('d.user = :user')
            ->andWhere('o.date >= :startDate')
            ->setParameter('user', $user)
            ->setParameter('startDate', new DateTime('-30 days'))
            ->getQuery()
            ->getSingleScalarResult();

        return $result ?? 0;
    }
}
