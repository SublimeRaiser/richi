<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DebtCollectionOperation extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    private $targetAccount;

    /**
     * @var Person|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     */
    private $person;

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
     * @return DebtCollectionOperation
     */
    public function setTargetAccount(?Account $account): self
    {
        $this->targetAccount = $account;

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
     * @return DebtCollectionOperation
     */
    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
