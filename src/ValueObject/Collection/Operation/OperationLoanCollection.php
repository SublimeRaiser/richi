<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationLoan;

class OperationLoanCollection extends BaseOperationCollection
{
    /**
     * OperationLoanCollection constructor.
     *
     * @param OperationLoan ...$elements
     */
    public function __construct(OperationLoan ...$elements)
    {
        parent::__construct($elements);
    }
}
