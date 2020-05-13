<?php

namespace App\ValueObject;

use App\ValueObject\Collection\Operation\BaseOperationCollection;
use DateTimeInterface;

class DatedOperations
{
    /** @var DateTimeInterface */
    private $date;

    /** @var BaseOperationCollection */
    private $operations;

    /**
     * DatedOperations constructor.
     *
     * @param DateTimeInterface       $date
     * @param BaseOperationCollection $operations
     */
    public function __construct(DateTimeInterface $date, BaseOperationCollection $operations)
    {
        $this->date       = $date;
        $this->operations = $operations;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return BaseOperationCollection
     */
    public function getOperations(): BaseOperationCollection
    {
        return $this->operations;
    }
}
