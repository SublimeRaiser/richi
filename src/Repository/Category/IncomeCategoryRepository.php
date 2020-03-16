<?php

namespace App\Repository\Category;

use App\Entity\Category\IncomeCategory;
use Doctrine\Common\Persistence\ManagerRegistry;

class IncomeCategoryRepository extends BaseCategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncomeCategory::class);
    }
}
