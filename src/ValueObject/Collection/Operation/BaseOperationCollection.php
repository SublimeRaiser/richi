<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\BaseOperation;
use App\ValueObject\Collection\BaseCollection;

class BaseOperationCollection extends BaseCollection
{
    /**
     * BaseOperationCollection constructor.
     *
     * @param BaseOperation ...$elements
     */
    public function __construct(BaseOperation ...$elements)
    {
        $this->elements = $elements;
    }
}
