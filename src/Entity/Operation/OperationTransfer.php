<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OperationTransfer extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $source;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $target;

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
     * @return OperationTransfer
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
     * @return OperationTransfer
     */
    public function setTarget(?Account $account): self
    {
        $this->target = $account;

        return $this;
    }
}
