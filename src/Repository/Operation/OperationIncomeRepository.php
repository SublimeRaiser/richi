<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationIncome;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationIncomeRepository extends BaseOperationCashFlowRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationIncome::class);
    }
}
