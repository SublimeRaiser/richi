<?php


namespace App\Service;

use App\Entity\Fund;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Repository\FundRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\ValueObject\Collection\FundCashCollection;
use App\ValueObject\Collection\FundCollection;
use App\ValueObject\FundCash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FundBalanceMonitor
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * FundBalanceMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Returns array of fund balances.
     *
     * @param UserInterface $user
     *
     * @return FundCashCollection
     */
    public function getBalances(UserInterface $user): FundCashCollection
    {
        $fundBalances = [];

        /** @var FundRepository $fundRepo */
        $fundRepo    = $this->em->getRepository(Fund::class);
        $funds       = $fundRepo->findByUser($user);
        $incomeSums  = $this->getIncomeSums($funds);
        $expenseSums = $this->getExpenseSums($funds);

        foreach ($funds as $fund) {
            // Consider initial balance
            $fundBalance = new FundCash($fund, $fund->getInitialBalance());

            // Consider incomes
            /** @var FundCash $incomeSum */
            foreach ($incomeSums as $incomeSum) {
                if ($incomeSum->getFund() !== $fund) {
                    continue;
                }
                $incomeSumValue = $incomeSum->getValue();
                $fundBalance    = new FundCash($fund, $fundBalance->getValue() + $incomeSumValue);
            }

            // Consider expenses
            /** @var FundCash $expenseSum */
            foreach ($expenseSums as $expenseSum) {
                if ($expenseSum->getFund() !== $fund) {
                    continue;
                }
                $expenseSumValue = $expenseSum->getValue();
                $fundBalance     = new FundCash($fund, $fundBalance->getValue() - $expenseSumValue);
            }

            $fundBalances[] = $fundBalance;
        }

        return new FundCashCollection(...$fundBalances);
    }

    /**
     *
     * Calculates total value for the provided balances.
     *
     * @param FundCashCollection $fundBalances
     *
     * @return integer
     */
    public function calculateTotal(FundCashCollection $fundBalances): int
    {
        $total = 0;

        /** @var FundCash $fundBalance */
        foreach ($fundBalances as $fundBalance) {
            $total += $fundBalance->getValue();
        }

        return $total;
    }

    /**
     * Returns an array with income sums for the provided funds.
     *
     * @param FundCollection $funds
     *
     * @return FundCashCollection
     */
    private function getIncomeSums(FundCollection $funds): FundCashCollection
    {
        /** @var OperationIncomeRepository $operationIncomeRepo */
        $operationIncomeRepo = $this->em->getRepository(OperationIncome::class);

        return $operationIncomeRepo->getFundCashFlowSums($funds);
    }

    /**
     * Returns an array with expense sums for the provided funds.
     *
     * @param FundCollection $funds
     *
     * @return FundCashCollection
     */
    private function getExpenseSums(FundCollection $funds): FundCashCollection
    {
        /** @var OperationExpenseRepository $operationExpenseRepo */
        $operationExpenseRepo = $this->em->getRepository(OperationExpense::class);

        return $operationExpenseRepo->getFundCashFlowSums($funds);
    }
}
