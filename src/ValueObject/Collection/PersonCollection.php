<?php

namespace App\ValueObject\Collection;

use App\Entity\Person;

class PersonCollection extends BaseCollection
{
    /**
     * PersonCollection constructor.
     *
     * @param Person ...$elements
     */
    public function __construct(Person ...$elements)
    {
        $this->elements = $elements;
    }
}
