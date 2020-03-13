<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class RepaymentOperation extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $sourceAccount;

    /**
     * @var Person|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     */
    private $person;

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
     * @return RepaymentOperation
     */
    public function setSourceAccount(?Account $account): self
    {
        $this->sourceAccount = $account;

        return $this;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     *
     * @return RepaymentOperation
     */
    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
