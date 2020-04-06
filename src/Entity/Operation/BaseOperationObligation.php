<?php

namespace App\Entity\Operation;

use App\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationObligation extends BaseOperation
{
    /**
     * @var Person|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $person;

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
     * @return self
     */
    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
