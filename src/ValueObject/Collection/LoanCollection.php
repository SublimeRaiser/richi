<?php

namespace App\ValueObject\Collection;

use App\Entity\Obligation\Loan;

class LoanCollection extends BaseCollection
{
    /**
     * LoanCollection constructor.
     *
     * @param Loan ...$elements
     */
    public function __construct(Loan ...$elements)
    {
        $this->elements = $elements;
    }
}
