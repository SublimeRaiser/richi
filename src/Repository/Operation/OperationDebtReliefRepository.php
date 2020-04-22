<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationDebtRelief;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationDebtReliefRepository extends BaseOperationDebtRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationDebtRelief::class);
    }
}
