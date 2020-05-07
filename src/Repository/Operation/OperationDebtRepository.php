<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Debt;
use App\Entity\Operation\OperationDebt;
use App\ValueObject\Collection\DebtCollection;
use App\ValueObject\Collection\DebtDateCollection;
use App\ValueObject\DebtDate;
use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationDebtRepository extends BaseOperationDebtRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationDebt::class);
    }

    /**
     * Finds out the date for all the debts provided.
     *
     * @param DebtCollection $debts
     *
     * @return DebtDateCollection
     */
    public function getDebtDates(DebtCollection $debts): DebtDateCollection
    {
        $debtDates = [];

        $results = $this->createQueryBuilder('o')
            ->select('d.id as debt_id, MIN(o.date) as date')
            ->leftJoin('o.debt', 'd')
            ->andWhere('o.debt in (:debts)')
            ->setParameter('debts', $debts->toArray())
            ->groupBy('o.debt')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $debtId = $result['debt_id'];
            $date   = DateTime::createFromFormat('!Y-m-d', $result['date']);
            $debt   = $this->findById($debts->toArray(), $debtId);
            /** @var Debt|null $debt */
            if ($debt) {
                $debtDates[] = new DebtDate($debt, $date);
            }
        }

        return new DebtDateCollection(...$debtDates);
    }
}
