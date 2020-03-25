<?php

namespace App\Entity\Operation;

use App\Entity\Category\CategoryExpense;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationRepository")
 */
class OperationExpense extends BaseOperationCashFlow
{
    /**
     * @var CategoryExpense
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryExpense")
     */
    protected $category;

    /**
     * @return CategoryExpense|null
     */
    public function getCategory(): ?CategoryExpense
    {
        return $this->category;
    }

    /**
     * @param CategoryExpense $category
     *
     * @return OperationExpense
     */
    public function setCategory(CategoryExpense $category): self
    {
        $this->category = $category;

        return $this;
    }
}
