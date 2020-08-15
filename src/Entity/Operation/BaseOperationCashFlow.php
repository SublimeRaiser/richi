<?php

namespace App\Entity\Operation;

use App\Entity\Fund;
use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationCashFlow extends BaseOperation
{
    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

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
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     *
     * @return self
     */
    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

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
