<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Debt;
use App\ValueObject\DebtCash;

abstract class BaseOperationDebtRepository extends BaseOperationRepository
{
    /**
     * Calculates the sum of all the cash flows for each of the debts provided.
     *
     * @param Debt[] $debts
     *
     * @return DebtCash[]
     */
    public function getDebtCashFlowSums(array $debts): array
    {
        $debtCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('d.id as debt_id, SUM(o.amount) as sum')
            ->leftJoin('o.debt', 'd')
            ->andWhere('o.debt in (:debts)')
            ->setParameter('debts', $debts)
            ->groupBy('o.debt')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $debtId             = $result['debt_id'];
            $sum                = $result['sum'];
            $debt               = $debts[$debtId];
            $debtCashFlowSums[] = new DebtCash($debt, $sum);
        }

        return $debtCashFlowSums;
    }
}
