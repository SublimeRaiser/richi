<?php

namespace App\ValueObject\Collection;

use App\ValueObject\PersonObligation;

class PersonObligationCollection extends BaseCollection
{
    /**
     * PersonObligationCollection constructor.
     *
     * @param PersonObligation ...$elements
     */
    public function __construct(PersonObligation ...$elements)
    {
        $this->elements = $elements;
    }
}
