<?php

namespace App\Repository\Category;

use App\Entity\Category\CategoryIncome;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryIncomeRepository extends BaseCategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryIncome::class);
    }
}
