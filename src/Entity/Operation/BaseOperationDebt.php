<?php

namespace App\Entity\Operation;

use App\Entity\Obligation\Debt;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationDebt extends BaseOperation
{
    /**
     * @var Debt
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Obligation\Debt")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $debt;

    /**
     * @return Debt|null
     */
    public function getDebt(): ?Debt
    {
        return $this->debt;
    }

    /**
     * @param Debt|null $debt
     *
     * @return self
     */
    public function setDebt(Debt $debt): self
    {
        $this->debt = $debt;

        return $this;
    }
}
