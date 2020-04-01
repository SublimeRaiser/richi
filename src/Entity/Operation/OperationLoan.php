<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationLoanRepository")
 */
class OperationLoan extends BaseOperationObligation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $source;

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
}
