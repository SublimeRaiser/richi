<?php

namespace App\Repository\Category;

use App\Entity\Category\CategoryExpense;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryExpenseRepository extends BaseCategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryExpense::class);
    }
}
