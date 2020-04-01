<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Category\CategoryIncome;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationIncomeRepository")
 */
class OperationIncome extends BaseOperationCashFlow
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $target;

    /**
     * @var CategoryIncome
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryIncome")
     */
    private $category;

    /**
     * @return Account|null
     */
    public function getTarget(): ?Account
    {
        return $this->target;
    }

    /**
     * @param Account|null $account
     *
     * @return self
     */
    public function setTarget(?Account $account): self
    {
        $this->target = $account;

        return $this;
    }

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
     * @return self
     */
    public function setCategory(?CategoryIncome $category): self
    {
        $this->category = $category;

        return $this;
    }
}
