<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationRepayment;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationRepaymentRepository extends BaseOperationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationRepayment::class);
    }
}
