<?php

namespace App\Repository;

use App\Entity\Debt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DebtRepository
 * @package App\Repository
 */
class DebtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Debt::class);
    }

    /**
     * Returns a debt list for the user.
     *
     * @param UserInterface $user
     *
     * @return Debt[]
     */
    public function findByUser(UserInterface $user): array
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.person', 'p')
            ->andWhere('d.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
