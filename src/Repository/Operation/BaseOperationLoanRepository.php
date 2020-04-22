<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Loan;
use App\ValueObject\LoanCash;

abstract class BaseOperationLoanRepository extends BaseOperationRepository
{
    /**
     * Calculates the sum of all the cash flows for each of the loans provided.
     *
     * @param Loan[] $loans
     *
     * @return LoanCash[]
     */
    public function getLoanCashFlowSums(array $loans): array
    {
        $loanCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('l.id as loan_id, SUM(o.amount) as sum')
            ->leftJoin('o.loan', 'l')
            ->andWhere('o.loan in (:loans)')
            ->setParameter('loans', $loans)
            ->groupBy('o.loan')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $loanId             = $result['loan_id'];
            $sum                = $result['sum'];
            $loan               = $loans[$loanId];
            $loanCashFlowSums[] = new LoanCash($loan, $sum);
        }

        return $loanCashFlowSums;
    }
}
