<?php

namespace App\Repository\Obligation;

use App\Entity\Obligation\Debt;
use App\Repository\BaseRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class DebtRepository extends BaseRepository
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
        $result = $this->createQueryBuilder('d')
            ->andWhere('d.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->addIndexes($result);
    }
}
