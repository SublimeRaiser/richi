<?php

namespace App\ValueObject\Collection;

use App\ValueObject\LoanCash;

class LoanCashCollection extends BaseCollection
{
    /**
     * LoanCashCollection constructor.
     *
     * @param LoanCash ...$elements
     */
    public function __construct(LoanCash ...$elements)
    {
        $this->elements = $elements;
    }
}
