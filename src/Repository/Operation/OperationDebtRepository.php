<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationDebt;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationDebtRepository extends BaseOperationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationDebt::class);
    }
}
