<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TransferOperation extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $sourceAccount;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $targetAccount;

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
     * @return TransferOperation
     */
    public function setSourceAccount(?Account $account): self
    {
        $this->sourceAccount = $account;

        return $this;
    }

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
     * @return TransferOperation
     */
    public function setTargetAccount(?Account $account): self
    {
        $this->targetAccount = $account;

        return $this;
    }
}
