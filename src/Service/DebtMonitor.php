<?php

namespace App\Service;

use App\Entity\Obligation\Debt;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationDebtRelief;
use App\Entity\Operation\OperationRepayment;
use App\Repository\Obligation\DebtRepository;
use App\Repository\Operation\OperationDebtReliefRepository;
use App\Repository\Operation\OperationDebtRepository;
use App\Repository\Operation\OperationRepaymentRepository;
use App\ValueObject\DebtSummary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DebtMonitor
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var DebtRepository */
    private $debtRepo;

    /** @var OperationDebtRepository */
    private $operationDebtRepo;

    /** @var OperationRepaymentRepository */
    private $operationRepaymentRepo;

    /** @var OperationDebtReliefRepository */
    private $operationDebtReliefRepo;

    /**
     * DebtMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em                      = $em;
        $this->debtRepo                = $em->getRepository(Debt::class);
        $this->operationDebtRepo       = $em->getRepository(OperationDebt::class);
        $this->operationRepaymentRepo  = $em->getRepository(OperationRepayment::class);
        $this->operationDebtReliefRepo = $em->getRepository(OperationDebtRelief::class);
    }

    /**
     * Returns an array with summaries for the debts.
     *
     * @param Debt[]|Debt $debts
     *
     * @return DebtSummary[]
     */
    public function getDebtSummaries($debts): array
    {
        if (!is_array($debts)) {
            $debts = [$debts];
        }

        $debtSummaries = [];

        $debtDates      = $this->operationDebtRepo->getDebtDates($debts);
        $debtSums       = $this->operationDebtRepo->getDebtCashFlowSums($debts);
        $repaymentSums  = $this->operationRepaymentRepo->getDebtCashFlowSums($debts);
        $debtReliefSums = $this->operationDebtReliefRepo->getDebtCashFlowSums($debts);
        foreach ($debts as $debt) {
            $date      = null;
            $amount    = 0;
            $repayment = 0;
            $relief    = 0;
            $remaining = 0;

            // Get date for debt
            foreach ($debtDates as $debtDate) {
                if ($debtDate->getDebt() !== $debt) {
                    continue;
                }
                $date = $debtDate->getDate();
            }

            // Consider debt operations
            foreach ($debtSums as $debtSum) {
                if ($debtSum->getDebt() !== $debt) {
                    continue;
                }
                $amount    += $debtSum->getValue();
                $remaining += $debtSum->getValue();
            }

            // Consider repayment operations
            foreach ($repaymentSums as $repaymentSum) {
                if ($repaymentSum->getDebt() !== $debt) {
                    continue;
                }
                $repayment += $repaymentSum->getValue();
                $remaining -= $repaymentSum->getValue();
            }

            // Consider debt relief operations
            foreach ($debtReliefSums as $debtReliefSum) {
                if ($debtReliefSum->getDebt() !== $debt) {
                    continue;
                }
                $relief    += $debtReliefSum->getValue();
                $remaining -= $debtReliefSum->getValue();
            }

            if ($debt && $amount) {
                $debtSummary     = new DebtSummary($debt, $date, $amount, $repayment, $relief, $remaining);
                $debtSummaries[] = $debtSummary;
            }
        }

        return $debtSummaries;
    }
}
