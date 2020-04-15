<?php


namespace App\Service;

use App\Entity\Operation\BaseOperation;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationDebtCollection;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Entity\Operation\OperationLoan;
use App\Entity\Operation\OperationRepayment;
use App\Entity\Operation\OperationTransfer;
use App\Repository\Operation\OperationDebtCollectionRepository;
use App\Repository\Operation\OperationDebtRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Repository\Operation\OperationLoanRepository;
use App\Repository\Operation\OperationRepaymentRepository;
use App\Repository\Operation\OperationTransferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OperationList
 * @package App\Service
 */
class OperationList
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var OperationExpenseRepository */
    private $operationExpenseRepo;

    /** @var OperationIncomeRepository */
    private $operationIncomeRepo;

    /** @var OperationTransferRepository */
    private $operationTransferRepo;

    /** @var OperationDebtRepository */
    private $operationDebtRepo;

    /** @var OperationRepaymentRepository */
    private $operationRepaymentRepo;

    /** @var OperationLoanRepository */
    private $operationLoanRepo;

    /** @var OperationDebtCollectionRepository */
    private $operationDebtCollectionRepo;

    /**
     * OperationList constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em                          = $em;
        $this->operationExpenseRepo        = $em->getRepository(OperationExpense::class);
        $this->operationIncomeRepo         = $em->getRepository(OperationIncome::class);
        $this->operationTransferRepo       = $em->getRepository(OperationTransfer::class);
        $this->operationDebtRepo           = $em->getRepository(OperationDebt::class);
        $this->operationRepaymentRepo      = $em->getRepository(OperationRepayment::class);
        $this->operationLoanRepo           = $em->getRepository(OperationLoan::class);
        $this->operationDebtCollectionRepo = $em->getRepository(OperationDebtCollection::class);
    }

    /**
     * Returns operation list with operations grouped by day.
     *
     * @param UserInterface $user
     *
     * @return BaseOperation[]
     */
    public function getGroupedByDays(UserInterface $user): array
    {
        $groupedOperations = [];

        $expenses        = $this->operationExpenseRepo->findByUser($user);
        $incomes         = $this->operationIncomeRepo->findByUser($user);
        $transfers       = $this->operationTransferRepo->findByUser($user);
        $debts           = $this->operationDebtRepo->findByUser($user);
        $repayments      = $this->operationRepaymentRepo->findByUser($user);
        $loans           = $this->operationLoanRepo->findByUser($user);
        $debtCollections = $this->operationDebtCollectionRepo->findByUser($user);

        $allOperations = array_merge($expenses, $incomes, $transfers, $debts, $repayments, $loans, $debtCollections);
        usort($allOperations, [$this, 'sortByDate']);

        /** @var BaseOperation $operation */
        foreach ($allOperations as $operation) {
            $operationDate                       = $operation->getDate()->getTimestamp();
            $groupedOperations[$operationDate][] = $operation;
        }

        return $groupedOperations;
    }

    /**
     * Compares operations by date, consider descending order.
     *
     * @param BaseOperation $a
     * @param BaseOperation $b
     *
     * @return integer
     */
    private function sortByDate(BaseOperation $a, BaseOperation $b): int
    {
        if ($a->getDate() < $b->getDate()) {
            return 1;
        }
        if ($a->getDate() > $b->getDate()) {
            return -1;
        }
        if ($a->getCreatedAt() < $b->getCreatedAt()) {
            return 1;
        }
        if ($a->getCreatedAt() > $b->getCreatedAt()) {
            return -1;
        }

        return 0;
    }
}
