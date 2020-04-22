<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationLoanRelief;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationLoanReliefRepository extends BaseOperationLoanRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationLoanRelief::class);
    }
}
