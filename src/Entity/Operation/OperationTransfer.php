<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationTransferRepository")
 */
class OperationTransfer extends BaseOperation
{
    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;

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
}
