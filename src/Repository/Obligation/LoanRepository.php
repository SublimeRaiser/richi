<?php

namespace App\Repository\Obligation;

use App\Entity\Obligation\Loan;
use App\Repository\BaseRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class LoanRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }
}
