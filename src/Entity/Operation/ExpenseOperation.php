<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Category\ExpenseCategory;
use App\Entity\Fund;
use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ExpenseOperation extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $sourceAccount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\ExpenseCategory")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag")
     */
    private $tag;

    /**
     * @var Fund
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Fund")
     */
    private $fund;

    /**
     * @return Account|null
     */
    public function getSourceAccount(): ?Account
    {
        return $this->sourceAccount;
    }

    /**
     * @param Account|null $account
     *
     * @return ExpenseOperation
     */
    public function setSourceAccount(?Account $account): self
    {
        $this->sourceAccount = $account;

        return $this;
    }

     /**
     * @return ExpenseCategory|null
     */
    public function getCategory(): ?ExpenseCategory
    {
        return $this->category;
    }

    /**
     * @param ExpenseCategory|null $category
     *
     * @return ExpenseOperation
     */
    public function setCategory(?ExpenseCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Tag|null
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag|null $tag
     *
     * @return ExpenseOperation
     */
    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Fund|null
     */
    public function getFund(): ?Fund
    {
        return $this->fund;
    }

    /**
     * @param Fund|null $fund
     *
     * @return ExpenseOperation
     */
    public function setFund(?Fund $fund): self
    {
        $this->fund = $fund;

        return $this;
    }
}
