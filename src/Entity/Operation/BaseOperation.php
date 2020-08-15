<?php

namespace App\Entity\Operation;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
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
     * @var DateTimeInterface
     *
     * @ORM\Column(name="`date`", type="date")
     */
    protected $date;

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
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $now             = new DateTime();
        $this->date      = $now;
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * @throws Exception
     */
    public function __clone()
    {
        if ($this->id) {
            $now             = new DateTime();
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
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     *
     * @return self
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

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
     * @return self
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
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate()
     *
     * @return void
     *
     * @throws Exception
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTime();
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
