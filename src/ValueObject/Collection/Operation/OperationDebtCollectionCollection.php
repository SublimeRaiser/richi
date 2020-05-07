<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationDebtCollection;

class OperationDebtCollectionCollection extends BaseOperationCollection
{
    /**
     * OperationDebtCollectionCollection constructor.
     *
     * @param OperationDebtCollection ...$elements
     */
    public function __construct(OperationDebtCollection ...$elements)
    {
        parent::__construct($elements);
    }
}
