<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationLoan;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationLoanRepository extends BaseOperationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationLoan::class);
    }
}
