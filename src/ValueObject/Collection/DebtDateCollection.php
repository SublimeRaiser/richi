<?php

namespace App\ValueObject\Collection;

use App\ValueObject\DebtDate;

class DebtDateCollection extends BaseCollection
{
    /**
     * DebtDateCollection constructor.
     *
     * @param DebtDate ...$elements
     */
    public function __construct(DebtDate ...$elements)
    {
        $this->elements = $elements;
    }
}
