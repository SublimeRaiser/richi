<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Fund;
use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationCashFlow extends BaseOperation
{
    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    protected $account;

    /**
     * @var Tag|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag")
     */
    protected $tag;

    /**
     * @var Fund|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Fund")
     */
    protected $fund;

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     *
     * @return self
     */
    public function setAccount(Account $account): self
    {
        $this->account = $account;

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
     * @return self
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
     * @return self
     */
    public function setFund(?Fund $fund): self
    {
        $this->fund = $fund;

        return $this;
    }
}
