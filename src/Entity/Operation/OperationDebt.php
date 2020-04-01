<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationDebtRepository")
 */
class OperationDebt extends BaseOperationObligation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $target;

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
