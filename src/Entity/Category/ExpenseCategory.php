<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Category\ExpenseCategoryRepository")
 */
class ExpenseCategory extends BaseCategory
{
    /**
     * @var self|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\ExpenseCategory")
     */
    protected $parent;
}
