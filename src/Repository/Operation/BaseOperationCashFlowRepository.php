<?php

namespace App\Repository\Operation;

use App\Entity\Fund;
use App\ValueObject\FundCash;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationCashFlowRepository extends BaseOperationRepository
{
    /**
     * Returns sum for all the cash flows.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUserCashFlowSum(UserInterface $user): int
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

    /**
     * Calculates the sum of all the cash flows for each of the funds provided.
     *
     * @param Fund[] $funds
     *
     * @return FundCash[]
     */
    public function getFundCashFlowSums(array $funds): array
    {
        $fundCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('f.id as fund_id, SUM(o.amount) as sum')
            ->leftJoin('o.fund', 'f')
            ->andWhere('o.fund in (:funds)')
            ->setParameter('funds', $funds)
            ->groupBy('o.fund')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $fundId = $result['fund_id'];
            $sum    = $result['sum'];
            $fund   = $this->findById($funds, $fundId);
            /** @var Fund|null $fund */
            if ($fund) {
                $fundCashFlowSums[] = new FundCash($fund, $sum);
            }
        }

        return $fundCashFlowSums;
    }
}
