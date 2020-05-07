<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Loan;
use App\ValueObject\Collection\LoanCashCollection;
use App\ValueObject\Collection\LoanCollection;
use App\ValueObject\LoanCash;

abstract class BaseOperationLoanRepository extends BaseOperationRepository
{
    /**
     * Calculates the sum of all the cash flows for each of the loans provided.
     *
     * @param LoanCollection $loans
     *
     * @return LoanCashCollection
     */
    public function getLoanCashFlowSums(LoanCollection $loans): LoanCashCollection
    {
        $loanCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('l.id as loan_id, SUM(o.amount) as sum')
            ->leftJoin('o.loan', 'l')
            ->andWhere('o.loan in (:loans)')
            ->setParameter('loans', $loans->toArray())
            ->groupBy('o.loan')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $loanId = $result['loan_id'];
            $sum    = $result['sum'];
            $loan   = $this->findById($loans->toArray(), $loanId);
            /** @var Loan|null $loan */
            if ($loan) {
                $loanCashFlowSums[] = new LoanCash($loan, $sum);
            }
        }

        return new LoanCashCollection(...$loanCashFlowSums);
    }
}
