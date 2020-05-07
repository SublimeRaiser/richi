<?php

namespace App\ValueObject\Collection;

use App\Entity\Fund;

class FundCollection extends BaseCollection
{
    /**
     * FundCollection constructor.
     *
     * @param Fund ...$elements
     */
    public function __construct(Fund ...$elements)
    {
        $this->elements = $elements;
    }
}
