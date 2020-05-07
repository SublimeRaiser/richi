<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationIncome;

class OperationIncomeCollection extends BaseOperationCollection
{
    /**
     * OperationIncomeCollection constructor.
     *
     * @param OperationIncome ...$elements
     */
    public function __construct(OperationIncome ...$elements)
    {
        parent::__construct($elements);
    }
}
