<?php

namespace App\ValueObject\Collection;

use App\ValueObject\DebtSummary;

class DebtSummaryCollection extends BaseCollection
{
    /**
     * DebtSummaryCollection constructor.
     *
     * @param DebtSummary ...$elements
     */
    public function __construct(DebtSummary ...$elements)
    {
        $this->elements = $elements;
    }
}
