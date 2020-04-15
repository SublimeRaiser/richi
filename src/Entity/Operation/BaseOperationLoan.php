<?php

namespace App\Entity\Operation;

use App\Entity\Obligation\Loan;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseOperationLoan extends BaseOperation
{
    /**
     * @var Loan
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Obligation\Loan")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $loan;

    /**
     * @return Loan|null
     */
    public function getLoan(): ?Loan
    {
        return $this->loan;
    }

    /**
     * @param Loan|null $loan
     *
     * @return self
     */
    public function setLoan(Loan $loan): self
    {
        $this->loan = $loan;

        return $this;
    }
}
