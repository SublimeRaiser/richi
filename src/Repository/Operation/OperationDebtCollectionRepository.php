<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationDebtCollection;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationDebtCollectionRepository extends BaseOperationLoanRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationDebtCollection::class);
    }
}
