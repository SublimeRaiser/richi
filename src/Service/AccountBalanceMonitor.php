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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountBalanceMonitor
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

        $inflowIncomeSums         = $operationIncomeRepo->getAccountInflowSums($accounts);
        $inflowTransferSums       = $operationTransferRepo->getAccountInflowSums($accounts);
        $inflowDebtSums           = $operationDebtRepo->getAccountInflowSums($accounts);
        $inflowDebtCollectionSums = $operationDebtCollectionRepo->getAccountInflowSums($accounts);

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

        $outflowExpenseSums   = $operationExpenseRepo->getAccountOutflowSums($accounts);
        $outflowTransferSums  = $operationTransferRepo->getAccountOutflowSums($accounts);
        $outflowLoanSums      = $operationLoanRepo->getAccountOutflowSums($accounts);
        $outflowRepaymentSums = $operationRepaymentRepo->getAccountOutflowSums($accounts);

        return array_merge($outflowExpenseSums, $outflowTransferSums, $outflowLoanSums, $outflowRepaymentSums);
    }
}
