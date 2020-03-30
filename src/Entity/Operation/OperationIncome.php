<?php

namespace App\Entity\Operation;

use App\Entity\Category\CategoryIncome;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationIncomeRepository")
 */
class OperationIncome extends BaseOperationCashFlow
{
    /**
     * @var CategoryIncome
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryIncome")
     */
    protected $category;

    /**
     * @return CategoryIncome|null
     */
    public function getCategory(): ?CategoryIncome
    {
        return $this->category;
    }

    /**
     * @param CategoryIncome|null $category
     *
     * @return OperationIncome
     */
    public function setCategory(?CategoryIncome $category): self
    {
        $this->category = $category;

        return $this;
    }
}
