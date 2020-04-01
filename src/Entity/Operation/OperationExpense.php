<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Category\CategoryExpense;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationExpenseRepository")
 */
class OperationExpense extends BaseOperationCashFlow
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $source;

    /**
     * @var CategoryExpense
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryExpense")
     */
    private $category;

    /**
     * @return Account|null
     */
    public function getSource(): ?Account
    {
        return $this->source;
    }

    /**
     * @param Account|null $account
     *
     * @return self
     */
    public function setSource(?Account $account): self
    {
        $this->source = $account;

        return $this;
    }

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
     * @return self
     */
    public function setCategory(CategoryExpense $category): self
    {
        $this->category = $category;

        return $this;
    }
}
