<?php

namespace App\Entity\Operation;

use App\Entity\Account;
use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationLiability extends BaseOperation
{
    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     */
    protected $account;

    /**
     * @var Person|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     */
    protected $person;

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account|null $account
     *
     * @return BaseOperationLiability
     */
    public function setAccount(?Account $account): self
    {
        $this->account = $account;

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
     * @return BaseOperationLiability
     */
    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
