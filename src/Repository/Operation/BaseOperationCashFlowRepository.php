<?php

namespace App\Repository\Operation;

use App\Entity\Fund;
use App\ValueObject\Collection\FundCashCollection;
use App\ValueObject\Collection\FundCollection;
use App\ValueObject\FundCash;
use DateTime;
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
    public function getUserCashFlowSumAll(UserInterface $user): int
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
     * Returns sum for the cash flows during the last 30 days.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUserCashFlowSum30Days(UserInterface $user): int
    {
        $result = $this->createQueryBuilder('o')
            ->select('SUM(o.amount)')
            ->andWhere('o.user = :user')
            ->andWhere('o.fund IS NULL')
            ->andWhere('o.date >= :startDate')
            ->setParameter('user', $user)
            ->setParameter('startDate', new DateTime('-30 days'))
            ->getQuery()
            ->getSingleScalarResult();

        return $result ?? 0;
    }

    /**
     * Calculates the sum of all the cash flows for each of the funds provided.
     *
     * @param FundCollection $funds
     *
     * @return FundCashCollection
     */
    public function getFundCashFlowSums(FundCollection $funds): FundCashCollection
    {
        $fundCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('f.id as fund_id, SUM(o.amount) as sum')
            ->leftJoin('o.fund', 'f')
            ->andWhere('o.fund in (:funds)')
            ->setParameter('funds', $funds->toArray())
            ->groupBy('o.fund')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $fundId = $result['fund_id'];
            $sum    = $result['sum'];
            $fund   = $this->findById($funds->toArray(), $fundId);
            /** @var Fund|null $fund */
            if ($fund) {
                $fundCashFlowSums[] = new FundCash($fund, $sum);
            }
        }

        return new FundCashCollection(...$fundCashFlowSums);
    }
}
