<?php


namespace App\Service;

use App\Entity\Obligation\Debt;
use App\Entity\Operation\BaseOperation;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationDebtCollection;
use App\Entity\Operation\OperationDebtRelief;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Entity\Operation\OperationLoan;
use App\Entity\Operation\OperationRepayment;
use App\Entity\Operation\OperationTransfer;
use App\Repository\Operation\OperationDebtCollectionRepository;
use App\Repository\Operation\OperationDebtReliefRepository;
use App\Repository\Operation\OperationDebtRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Repository\Operation\OperationLoanRepository;
use App\Repository\Operation\OperationRepaymentRepository;
use App\Repository\Operation\OperationTransferRepository;
use App\ValueObject\Collection\DatedOperationsCollection;
use App\ValueObject\Collection\Operation\BaseOperationCollection;
use App\ValueObject\DatedOperations;
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

    /** @var OperationDebtReliefRepository */
    private $operationDebtReliefRepo;

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
        $this->operationDebtReliefRepo     = $em->getRepository(OperationDebtRelief::class);
        $this->operationLoanRepo           = $em->getRepository(OperationLoan::class);
        $this->operationDebtCollectionRepo = $em->getRepository(OperationDebtCollection::class);
    }

    /**
     * Returns operation list with operations grouped by day.
     *
     * @param UserInterface $user
     *
     * @return DatedOperationsCollection
     */
    public function getDatedOperationsCollection(UserInterface $user): DatedOperationsCollection
    {
        $expenses        = $this->operationExpenseRepo->findByUser($user);
        $incomes         = $this->operationIncomeRepo->findByUser($user);
        $transfers       = $this->operationTransferRepo->findByUser($user);
        $debts           = $this->operationDebtRepo->findByUser($user);
        $repayments      = $this->operationRepaymentRepo->findByUser($user);
        $debtReliefs     = $this->operationDebtReliefRepo->findByUser($user);
        $loans           = $this->operationLoanRepo->findByUser($user);
        $debtCollections = $this->operationDebtCollectionRepo->findByUser($user);

        $allOperations = new BaseOperationCollection(
            ...$expenses->toArray(),
            ...$incomes->toArray(),
            ...$transfers->toArray(),
            ...$debts->toArray(),
            ...$repayments->toArray(),
            ...$debtReliefs->toArray(),
            ...$loans->toArray(),
            ...$debtCollections->toArray()
        );

        $datedOperations = [];
        /** @var BaseOperation $operation */
        foreach ($allOperations as $operation) {
            // Operation date timestamp is used as an array key to group operations with the same date
            $operationDateTimestamp = $operation->getDate()->getTimestamp();
            if (!array_key_exists($operationDateTimestamp, $datedOperations)) {
                $datedOperations[$operationDateTimestamp] = $this->initDatedOperations($operation);
            } else {
                $datedOperations[$operationDateTimestamp] =
                    $this->replenishDatedOperations($datedOperations[$operationDateTimestamp], $operation);
            }
        }

        $datedOperationsCollection = new DatedOperationsCollection(...$datedOperations);
        $datedOperationsCollection = $datedOperationsCollection->sortByDate();

        return $datedOperationsCollection;
    }

    /**
     * Returns operation list for the debt.
     *
     * @param Debt $debt
     *
     * @return BaseOperationCollection
     */
    public function getOperationsByDebt(Debt $debt): BaseOperationCollection
    {
        $debts       = $this->operationDebtRepo->findByDebt($debt);
        $repayments  = $this->operationRepaymentRepo->findByDebt($debt);
        $debtReliefs = $this->operationDebtReliefRepo->findByDebt($debt);

        $allOperations = array_merge(
            $debts->toArray(),
            $repayments->toArray(),
            $debtReliefs->toArray()
        );
        usort($allOperations, [$this, 'sortByDate']);

        return new BaseOperationCollection(...$allOperations);
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

    /**
     * Initializes a dated operations with the given operation.
     *
     * @param BaseOperation $operation
     *
     * @return DatedOperations
     */
    private function initDatedOperations(BaseOperation $operation): DatedOperations
    {
        $operationDate = $operation->getDate();

        return new DatedOperations($operationDate, new BaseOperationCollection($operation));
    }

    /**
     * Replenishes the existing dated operations with the given operation.
     *
     * @param DatedOperations $existingOperations
     * @param BaseOperation   $operation
     *
     * @return DatedOperations
     */
    private function replenishDatedOperations(
        DatedOperations $existingOperations,
        BaseOperation $operation
    ): DatedOperations {
        $operationDate = $operation->getDate();

        return new DatedOperations(
            $operationDate,
            new BaseOperationCollection($operation, ...$existingOperations->getOperations()->toArray())
        );
    }
}
