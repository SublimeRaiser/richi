<?php

namespace App\Repository\Category;

use App\Entity\Category\ExpenseCategory;
use Doctrine\Common\Persistence\ManagerRegistry;

class ExpenseCategoryRepository extends BaseCategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseCategory::class);
    }
}
