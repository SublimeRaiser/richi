<?php

namespace App\ValueObject\Collection;

use App\Entity\Tag;

class TagCollection extends BaseCollection
{
    /**
     * TagCollection constructor.
     *
     * @param Tag ...$elements
     */
    public function __construct(Tag ...$elements)
    {
        $this->elements = $elements;
    }
}
