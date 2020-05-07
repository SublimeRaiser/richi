<?php

namespace App\ValueObject\Collection;

use App\ValueObject\FundCash;

class FundCashCollection extends BaseCollection
{
    /**
     * FundCashCollection constructor.
     *
     * @param FundCash ...$elements
     */
    public function __construct(FundCash ...$elements)
    {
        $this->elements = $elements;
    }
}
