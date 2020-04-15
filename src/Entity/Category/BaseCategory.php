<?php

namespace App\Entity\Category;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class BaseCategory implements CategoryParentAwareInterface
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $icon;

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
     * @var self|null
     */
    protected $parent;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $now              = new DateTime();
        $this->createdAt  = $now;
        $this->updatedAt  = $now;
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->name;
        if ($this->parent) {
            $string = $this->parent->getName() . ' / ' . $string;
        }

        return $string;
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
     * @return self
     */
    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     *
     * @return self
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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
     * @return BaseCategory|null
     */
    public function getParent(): ?BaseCategory
    {
        return $this->parent;
    }

    /**
     * @param BaseCategory|null $parent
     *
     * @return BaseCategory
     */
    public function setParent(?BaseCategory $parent): BaseCategory
    {
        if (!$parent instanceof self) {
            throw new InvalidArgumentException('Invalid parent class.');
        }

        $this->parent = $parent;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     *
     * @return void
     *
     * @throws Exception
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTime();
    }
}
