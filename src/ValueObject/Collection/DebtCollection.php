<?php

namespace App\ValueObject\Collection;

use App\Entity\Obligation\Debt;

class DebtCollection extends BaseCollection
{
    /**
     * DebtCollection constructor.
     *
     * @param Debt ...$elements
     */
    public function __construct(Debt ...$elements)
    {
        $this->elements = $elements;
    }
}
