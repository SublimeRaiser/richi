<?php

namespace App\ValueObject;

use App\Entity\Obligation\Loan;

class LoanCash
{
    /** @var Loan */
    private $loan;

    /** @var integer */
    private $value;

    /**
     * LoanCash constructor.
     *
     * @param Loan    $loan
     * @param integer $value
     */
    public function __construct(Loan $loan, int $value)
    {
        $this->loan  = $loan;
        $this->value = $value;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
