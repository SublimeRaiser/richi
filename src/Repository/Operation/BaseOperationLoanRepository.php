<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Loan;
use App\ValueObject\Collection\LoanCashCollection;
use App\ValueObject\Collection\LoanCollection;
use App\ValueObject\Collection\Operation\BaseOperationCollection;
use App\ValueObject\LoanCash;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationLoanRepository extends BaseOperationRepository
{
    /**
     * Returns an operation list.
     *
     * @param UserInterface $user
     *
     * @return BaseOperationCollection
     */
    public function findByUser(UserInterface $user): BaseOperationCollection
    {
        $result = $this->createQueryBuilder('o')
            ->leftJoin('o.loan', 'l')
            ->andWhere('l.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return new BaseOperationCollection(...$result);
    }

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

    /**
     * Returns a collection of operations related to the loan.
     *
     * @param Loan $loan
     *
     * @return BaseOperationCollection
     */
    public function findByLoan(Loan $loan): BaseOperationCollection
    {
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.loan = :loan')
            ->setParameter('loan', $loan)
            ->getQuery()
            ->getResult();

        return new BaseOperationCollection(...$result);
    }
}
