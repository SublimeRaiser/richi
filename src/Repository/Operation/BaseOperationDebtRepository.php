<?php

namespace App\Repository\Operation;

use App\Entity\Obligation\Debt;
use App\ValueObject\Collection\DebtCashCollection;
use App\ValueObject\Collection\DebtCollection;
use App\ValueObject\Collection\Operation\BaseOperationCollection;
use App\ValueObject\DebtCash;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationDebtRepository extends BaseOperationRepository
{
   /**
     * Returns an operation list.
     *
     * @param UserInterface $user
     *
     * @return BaseOperationCollection
     */
    public function findByUser(UserInterface $user): BaseOperationCollection
    {
        $result = $this->createQueryBuilder('o')
            ->leftJoin('o.debt', 'd')
            ->andWhere('d.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return new BaseOperationCollection(...$result);
    }

    /**
     * Calculates the sum of all the cash flows for each of the debts provided.
     *
     * @param DebtCollection $debts
     *
     * @return DebtCashCollection
     */
    public function getDebtCashFlowSums(DebtCollection $debts): DebtCashCollection
    {
        $debtCashFlowSums = [];

        $results = $this->createQueryBuilder('o')
            ->select('d.id as debt_id, SUM(o.amount) as sum')
            ->leftJoin('o.debt', 'd')
            ->andWhere('o.debt in (:debts)')
            ->setParameter('debts', $debts->toArray())
            ->groupBy('o.debt')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $debtId = $result['debt_id'];
            $sum    = $result['sum'];
            $debt   = $this->findById($debts->toArray(), $debtId);
            /** @var Debt|null $debt */
            if ($debt) {
                $debtCashFlowSums[] = new DebtCash($debt, $sum);
            }
        }

        return new DebtCashCollection(...$debtCashFlowSums);
    }

    /**
     * Returns a collection of operations related to the debt.
     *
     * @param Debt $debt
     *
     * @return BaseOperationCollection
     */
    public function findByDebt(Debt $debt): BaseOperationCollection
    {
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.debt = :debt')
            ->setParameter('debt', $debt)
            ->getQuery()
            ->getResult();

        return new BaseOperationCollection(...$result);
    }
}
