<?php

namespace App\ValueObject\Collection;

use App\Entity\Category\BaseCategory;

class BaseCategoryCollection extends BaseCollection
{
    /**
     * BaseCategoryCollection constructor.
     *
     * @param BaseCategory ...$elements
     */
    public function __construct(BaseCategory ...$elements)
    {
        $this->elements = $elements;
    }
}
