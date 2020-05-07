<?php

namespace App\ValueObject\Collection\Operation;

use App\Entity\Operation\OperationTransfer;

class OperationTransferCollection extends BaseOperationCollection
{
    /**
     * OperationTransferCollection constructor.
     *
     * @param OperationTransfer ...$elements
     */
    public function __construct(OperationTransfer ...$elements)
    {
        parent::__construct($elements);
    }
}
