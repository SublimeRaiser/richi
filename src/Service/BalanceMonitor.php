<?php


namespace App\Service;

use App\Entity\Account;
use App\Entity\Fund;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationDebtCollection;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Entity\Operation\OperationLoan;
use App\Entity\Operation\OperationRepayment;
use App\Entity\Operation\OperationTransfer;
use App\Enum\OperationTypeEnum;
use App\Repository\AccountRepository;
use App\Repository\FundRepository;
use App\Repository\Operation\OperationDebtCollectionRepository;
use App\Repository\Operation\OperationDebtRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Repository\Operation\OperationLoanRepository;
use App\Repository\Operation\OperationRepaymentRepository;
use App\Repository\Operation\OperationTransferRepository;
use App\ValueObject\AccountCash;
use App\ValueObject\FundCash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BalanceMonitor
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * BalanceMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Returns array of account balances.
     *
     * @param UserInterface $user
     *
     * @return AccountCash[]
     */
    public function getAccountBalances(UserInterface $user): array
    {
        $accountBalances = [];

        /** @var AccountRepository $accountRepo */
        $accountRepo = $this->em->getRepository(Account::class);
        $accounts    = $accountRepo->findByUser($user);
        $inflowSums  = $this->getInflowSums($accounts);
        $outflowSums = $this->getOutflowSums($accounts);

        foreach ($accounts as $account) {
            // Consider initial balance
            $accountBalance = new AccountCash($account, $account->getInitialBalance());

            // Consider inflows
            /** @var AccountCash $inflowSum */
            foreach ($inflowSums as $inflowSum) {
                if ($inflowSum->getAccount() !== $account) {
                    continue;
                }
                $inflowSumValue = $inflowSum->getValue();
                $accountBalance = new AccountCash($account, $accountBalance->getValue() + $inflowSumValue);
            }

            // Consider outflows
            /** @var AccountCash $outflowSum */
            foreach ($outflowSums as $outflowSum) {
                if ($outflowSum->getAccount() !== $account) {
                    continue;
                }
                $outflowSumValue = $outflowSum->getValue();
                $accountBalance  = new AccountCash($account, $accountBalance->getValue() - $outflowSumValue);
            }

            $accountBalances[] = $accountBalance;
        }

        return $accountBalances;
    }

    /**
     * @param AccountCash[] $accountBalances
     *
     * @return integer
     */
    public function calculateTotal(array $accountBalances): int
    {
        $total = 0;

        foreach ($accountBalances as $accountBalance) {
            $total += $accountBalance->getValue();
        }

        return $total;
    }

    /**
     * Returns array of fund balances.
     *
     * @param UserInterface $user
     *
     * @return FundCash[]
     */
    public function getFundBalances(UserInterface $user): array
    {
        $fundBalances = [];

        /** @var FundRepository $fundRepo */
        $fundRepo    = $this->em->getRepository(Fund::class);
        $funds       = $fundRepo->findByUser($user);
        $incomeSums  = $this->operationRepo->getFundCashFlowSums($funds, OperationTypeEnum::TYPE_INCOME);
        $expenseSums = $this->operationRepo->getFundCashFlowSums($funds, OperationTypeEnum::TYPE_EXPENSE);

        foreach ($funds as $fund) {
            // Consider initial balance
            $fundBalance = new FundCash($fund, $fund->getInitialBalance());

            // Consider incomes
            foreach ($incomeSums as $incomeSum) {
                if ($incomeSum->getFund() !== $fund) {
                    continue;
                }
                $incomeSumValue = $incomeSum->getValue();
                $fundBalance    = new FundCash($fund, $fundBalance->getValue() + $incomeSumValue);
            }

            // Consider expenses
            foreach ($expenseSums as $expenseSum) {
                if ($expenseSum->getFund() !== $fund) {
                    continue;
                }
                $expenseSumValue = $expenseSum->getValue();
                $fundBalance     = new FundCash($fund, $fundBalance->getValue() - $expenseSumValue);
            }

            $fundBalances[] = $fundBalance;
        }

        return $fundBalances;
    }

    /**
     * @param FundCash[] $fundBalances
     *
     * @return integer
     */
    public function calculateFundBalance(array $fundBalances): int
    {
        $total = 0;

        foreach ($fundBalances as $fundBalance) {
            $total += $fundBalance->getValue();
        }

        return $total;
    }

    /**
     * Returns an array with inflow sums for the provided accounts.
     *
     * @param Account[] $accounts
     *
     * @return AccountCash[]
     */
    private function getInflowSums(array $accounts): array
    {
        /** @var OperationIncomeRepository $operationIncomeRepo */
        $operationIncomeRepo         = $this->em->getRepository(OperationIncome::class);
        /** @var OperationTransferRepository $operationTransferRepo */
        $operationTransferRepo       = $this->em->getRepository(OperationTransfer::class);
        /** @var OperationDebtRepository $operationDebtRepo */
        $operationDebtRepo           = $this->em->getRepository(OperationDebt::class);
        /** @var OperationDebtCollectionRepository $operationDebtCollectionRepo */
        $operationDebtCollectionRepo = $this->em->getRepository(OperationDebtCollection::class);

        $inflowIncomeSums         = $operationIncomeRepo->getInflowSums($accounts);
        $inflowTransferSums       = $operationTransferRepo->getInflowSums($accounts);
        $inflowDebtSums           = $operationDebtRepo->getInflowSums($accounts);
        $inflowDebtCollectionSums = $operationDebtCollectionRepo->getInflowSums($accounts);

        return array_merge($inflowIncomeSums, $inflowTransferSums, $inflowDebtSums, $inflowDebtCollectionSums);
    }

    /**
     * Returns an array with outflow sums for the provided accounts.
     *
     * @param Account[] $accounts
     *
     * @return AccountCash[]
     */
    private function getOutflowSums(array $accounts): array
    {
        /** @var OperationExpenseRepository $operationExpenseRepo */
        $operationExpenseRepo   = $this->em->getRepository(OperationExpense::class);
        /** @var OperationTransferRepository $operationTransferRepo */
        $operationTransferRepo  = $this->em->getRepository(OperationTransfer::class);
        /** @var OperationLoanRepository $operationLoanRepo */
        $operationLoanRepo      = $this->em->getRepository(OperationLoan::class);
        /** @var OperationRepaymentRepository $operationRepaymentRepo */
        $operationRepaymentRepo = $this->em->getRepository(OperationRepayment::class);

        $outflowExpenseSums   = $operationExpenseRepo->getOutflowSums($accounts);
        $outflowTransferSums  = $operationTransferRepo->getOutflowSums($accounts);
        $outflowLoanSums      = $operationLoanRepo->getOutflowSums($accounts);
        $outflowRepaymentSums = $operationRepaymentRepo->getOutflowSums($accounts);

        return array_merge($outflowExpenseSums, $outflowTransferSums, $outflowLoanSums, $outflowRepaymentSums);
    }
}
