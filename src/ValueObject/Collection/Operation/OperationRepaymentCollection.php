<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationRepayment;

class OperationRepaymentCollection extends BaseOperationCollection
{
    /**
     * OperationRepaymentCollection constructor.
     *
     * @param OperationRepayment ...$elements
     */
    public function __construct(OperationRepayment ...$elements)
    {
        parent::__construct($elements);
    }
}
