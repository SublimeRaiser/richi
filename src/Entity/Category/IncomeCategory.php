<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Category\IncomeCategoryRepository")
 */
class IncomeCategory extends BaseCategory
{
    /**
     * @var self|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\IncomeCategory")
     */
    protected $parent;
}
