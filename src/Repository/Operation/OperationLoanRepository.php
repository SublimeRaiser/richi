<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationLoan;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationLoanRepository extends BaseOperationLoanRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationLoan::class);
    }
}
