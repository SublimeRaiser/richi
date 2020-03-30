<?php

namespace App\Repository\Operation;

use App\Entity\Operation\OperationTransfer;
use Doctrine\Common\Persistence\ManagerRegistry;

class OperationTransferRepository extends BaseOperationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationTransfer::class);
    }
}
