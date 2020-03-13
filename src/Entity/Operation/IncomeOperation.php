<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Fund;
use App\Entity\Category\IncomeCategory;
use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class IncomeOperation extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $targetAccount;

    /**
     * @var IncomeCategory
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\IncomeCategory")
     */
    private $category;

    /**
     * @var Tag
     *
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
    public function getTargetAccount(): ?Account
    {
        return $this->targetAccount;
    }

    /**
     * @param Account|null $account
     *
     * @return IncomeOperation
     */
    public function setTargetAccount(?Account $account): self
    {
        $this->targetAccount = $account;

        return $this;
    }

    /**
     * @return IncomeCategory|null
     */
    public function getCategory(): ?IncomeCategory
    {
        return $this->category;
    }

    /**
     * @param IncomeCategory|null $category
     *
     * @return IncomeOperation
     */
    public function setCategory(?IncomeCategory $category): self
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
     * @return IncomeOperation
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
     * @return IncomeOperation
     */
    public function setFund(?Fund $fund): self
    {
        $this->fund = $fund;

        return $this;
    }
}
