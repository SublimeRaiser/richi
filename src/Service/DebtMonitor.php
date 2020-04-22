<?php

namespace App\Service;

use App\Entity\Obligation\Debt;
use App\Entity\Operation\OperationDebt;
use App\Entity\Operation\OperationRepayment;
use App\Repository\Obligation\DebtRepository;
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

    /**
     * DebtMonitor constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em                     = $em;
        $this->debtRepo               = $em->getRepository(Debt::class);
        $this->operationDebtRepo      = $em->getRepository(OperationDebt::class);
        $this->operationRepaymentRepo = $em->getRepository(OperationRepayment::class);
    }

    /**
     * @param UserInterface $user
     *
     * @return DebtSummary[]
     */
    public function getDebtSummaries(UserInterface $user): array
    {
        $debtSummaries = [];

        $debts         = $this->debtRepo->findByUser($user);
        $debtDates     = $this->operationDebtRepo->getDebtDates($debts);
        $debtSums      = $this->operationDebtRepo->getDebtCashFlowSums($debts);
        $repaymentSums = $this->operationRepaymentRepo->getDebtCashFlowSums($debts);
        foreach ($debts as $debt) {
            $date      = null;
            $amount    = 0;
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
                $remaining -= $repaymentSum->getValue();
            }

            if ($debt && $amount) {
                $debtSummary     = new DebtSummary($debt, $date, $amount, $remaining);
                $debtSummaries[] = $debtSummary;
            }
        }

        return $debtSummaries;
    }
}
