<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationExpense;

class OperationExpenseCollection extends BaseOperationCollection
{
    /**
     * OperationExpenseCollection constructor.
     *
     * @param OperationExpense ...$elements
     */
    public function __construct(OperationExpense ...$elements)
    {
        parent::__construct($elements);
    }
}
