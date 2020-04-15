<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationExpense;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationExpenseRepository extends BaseOperationCashFlowRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationExpense::class);
    }
}
