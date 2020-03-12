<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class BaseOperation
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="`date`", type="date")
     */
    protected $date;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    protected $account;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * Operation constructor.
     */
    public function __construct()
    {
        $now             = new \DateTime();
        $this->date      = $now;
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        if ($this->id) {
            $now             = new \DateTime();
            $this->createdAt = $now;
            $this->updatedAt = $now;
        }
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

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
     * @return BaseOperation
     */
    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     *
     * @return BaseOperation
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account|null $source
     *
     * @return BaseOperation
     */
    public function setAccount(?Account $source): self
    {
        $this->account = $source;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param integer $amount
     *
     * @return BaseOperation
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return BaseOperation
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate()
     *
     * @return void
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     *
     * @return void
     */
    public function validateFields(ExecutionContextInterface $context): void
    {
        if ($this->amount <= 0) {
            $context
                ->buildViolation('Amount should be greater than zero')
                ->atPath('amount')
                ->addViolation();
        }
    }
}
