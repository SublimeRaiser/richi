<?php

namespace App\Service;

use App\Entity\Operation\OperationDebtRelief;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Entity\Operation\OperationLoanRelief;
use App\Repository\Operation\OperationDebtReliefRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Repository\Operation\OperationLoanReliefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;

class TotalsMonitor
{
    /** @var EntityManagerInterface*/
    private $em;

    /**
     * ExpenseMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Calculates the sum of all the expense cash flow and loan relief operations for the last 30 days.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getExpenseSumLast30Days(UserInterface $user): int
    {
        /** @var OperationExpenseRepository $operationExpenseRepo */
        $operationExpenseRepo    = $this->em->getRepository(OperationExpense::class);
        /** @var OperationLoanReliefRepository $operationLoanReliefRepo */
        $operationLoanReliefRepo = $this->em->getRepository(OperationLoanRelief::class);

        $expenseCashFlowSum = $operationExpenseRepo->getCashFlowSum30Days($user);
        $loanReliefSum      = $operationLoanReliefRepo->getLoanReliefSum30Days($user);

        return $expenseCashFlowSum + $loanReliefSum;
    }

    /**
     * Calculates the sum of all the income cash flow and debt relief operations for the last 30 days.
     *
     * @param UserInterface $user
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getIncomeSumLast30Days(UserInterface $user): int
    {
        /** @var OperationIncomeRepository $operationIncomeRepo */
        $operationIncomeRepo     = $this->em->getRepository(OperationIncome::class);
        /** @var OperationDebtReliefRepository $operationDebtReliefRepo */
        $operationDebtReliefRepo = $this->em->getRepository(OperationDebtRelief::class);

        $incomeCashFlowSum = $operationIncomeRepo->getCashFlowSum30Days($user);
        $debtReliefSum     = $operationDebtReliefRepo->getDebtReliefSum30Days($user);

        return $incomeCashFlowSum + $debtReliefSum;
    }
}
