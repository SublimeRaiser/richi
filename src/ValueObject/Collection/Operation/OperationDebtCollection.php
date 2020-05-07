<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationDebt;

class OperationDebtCollection extends BaseOperationCollection
{
    /**
     * OperationDebtCollection constructor.
     *
     * @param OperationDebt ...$elements
     */
    public function __construct(OperationDebt ...$elements)
    {
        parent::__construct($elements);
    }
}
