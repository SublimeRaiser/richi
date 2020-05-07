<?php

namespace App\ValueObject\Collection;

use App\ValueObject\DebtCash;

class DebtCashCollection extends BaseCollection
{
    /**
     * DebtCashCollection constructor.
     *
     * @param DebtCash ...$elements
     */
    public function __construct(DebtCash ...$elements)
    {
        $this->elements = $elements;
    }
}
