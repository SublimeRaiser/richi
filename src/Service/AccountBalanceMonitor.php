<?php


namespace App\Service;

use App\Entity\Account;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationDebtCollection;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Entity\Operation\OperationLoan;
use App\Entity\Operation\OperationRepayment;
use App\Entity\Operation\OperationTransfer;
use App\Repository\AccountRepository;
use App\Repository\Operation\OperationDebtCollectionRepository;
use App\Repository\Operation\OperationDebtRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Repository\Operation\OperationLoanRepository;
use App\Repository\Operation\OperationRepaymentRepository;
use App\Repository\Operation\OperationTransferRepository;
use App\ValueObject\AccountCash;
use App\ValueObject\Collection\AccountCashCollection;
use App\ValueObject\Collection\AccountCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountBalanceMonitor
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * AccountBalanceMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Returns a collection of account balances.
     *
     * @param UserInterface $user
     *
     * @return AccountCashCollection
     */
    public function getBalances(UserInterface $user): AccountCashCollection
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

        return new AccountCashCollection(...$accountBalances);
    }

    /**
     * Calculates total value for the provided balances.
     *
     * @param AccountCashCollection $accountBalances
     *
     * @return integer
     */
    public function calculateTotal(AccountCashCollection $accountBalances): int
    {
        $total = 0;

        /** @var AccountCash $accountBalance */
        foreach ($accountBalances as $accountBalance) {
            $total += $accountBalance->getValue();
        }

        return $total;
    }

    /**
     * Returns a collection with inflow sums for the provided accounts.
     *
     * @param AccountCollection $accounts
     *
     * @return AccountCashCollection
     */
    private function getInflowSums(AccountCollection $accounts): AccountCashCollection
    {
        /** @var OperationIncomeRepository $operationIncomeRepo */
        $operationIncomeRepo         = $this->em->getRepository(OperationIncome::class);
        /** @var OperationTransferRepository $operationTransferRepo */
        $operationTransferRepo       = $this->em->getRepository(OperationTransfer::class);
        /** @var OperationDebtRepository $operationDebtRepo */
        $operationDebtRepo           = $this->em->getRepository(OperationDebt::class);
        /** @var OperationDebtCollectionRepository $operationDebtCollectionRepo */
        $operationDebtCollectionRepo = $this->em->getRepository(OperationDebtCollection::class);

        $inflowIncomeSums         = $operationIncomeRepo->getAccountInflowSums($accounts);
        $inflowTransferSums       = $operationTransferRepo->getAccountInflowSums($accounts);
        $inflowDebtSums           = $operationDebtRepo->getAccountInflowSums($accounts);
        $inflowDebtCollectionSums = $operationDebtCollectionRepo->getAccountInflowSums($accounts);

        $inflowSums = array_merge(
            $inflowIncomeSums->toArray(),
            $inflowTransferSums->toArray(),
            $inflowDebtSums->toArray(),
            $inflowDebtCollectionSums->toArray()
        );

        return new AccountCashCollection(...$inflowSums);
    }

    /**
     * Returns a collection with outflow sums for the provided accounts.
     *
     * @param AccountCollection $accounts
     *
     * @return AccountCashCollection
     */
    private function getOutflowSums(AccountCollection $accounts): AccountCashCollection
    {
        /** @var OperationExpenseRepository $operationExpenseRepo */
        $operationExpenseRepo   = $this->em->getRepository(OperationExpense::class);
        /** @var OperationTransferRepository $operationTransferRepo */
        $operationTransferRepo  = $this->em->getRepository(OperationTransfer::class);
        /** @var OperationLoanRepository $operationLoanRepo */
        $operationLoanRepo      = $this->em->getRepository(OperationLoan::class);
        /** @var OperationRepaymentRepository $operationRepaymentRepo */
        $operationRepaymentRepo = $this->em->getRepository(OperationRepayment::class);

        $outflowExpenseSums   = $operationExpenseRepo->getAccountOutflowSums($accounts);
        $outflowTransferSums  = $operationTransferRepo->getAccountOutflowSums($accounts);
        $outflowLoanSums      = $operationLoanRepo->getAccountOutflowSums($accounts);
        $outflowRepaymentSums = $operationRepaymentRepo->getAccountOutflowSums($accounts);

        $outflowSums = array_merge(
            $outflowExpenseSums->toArray(),
            $outflowTransferSums->toArray(),
            $outflowLoanSums->toArray(),
            $outflowRepaymentSums->toArray()
        );

        return new AccountCashCollection(...$outflowSums);
    }
}
