<?php

namespace App\ValueObject\Collection;

use App\Entity\Operation\BaseOperation;
use App\ValueObject\Collection\Operation\BaseOperationCollection;
use App\ValueObject\DatedOperations;

class DatedOperationsCollection extends BaseCollection
{
    /**
     * DatedOperationsCollection constructor.
     *
     * @param DatedOperations ...$elements
     */
    public function __construct(DatedOperations ...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * Returns copy of the collection sorted by date.
     *
     * @return DatedOperationsCollection
     */
    public function sortByDate(): self
    {
        $sortedDatedOperationsArray = [];

        $datedOperationsArray = $this->toArray();
        usort($datedOperationsArray, [$this, 'compareDatedOperationsByDate']);

        /** @var DatedOperations $datedOperations */
        foreach ($datedOperationsArray as $datedOperations) {
            $operationsDate  = $datedOperations->getDate();
            $operationsArray = $datedOperations->getOperations()->toArray();
            usort($operationsArray, [$this, 'compareOperationsByCreatedAt']);

            $sortedDatedOperationsArray[] =
                new DatedOperations($operationsDate, new BaseOperationCollection(...$operationsArray));
        }

        return new self(...$sortedDatedOperationsArray);
    }

    /**
     * Compares dated operations by date, consider descending order.
     *
     * @param DatedOperations $a
     * @param DatedOperations $b
     *
     * @return integer
     */
    private function compareDatedOperationsByDate(DatedOperations $a, DatedOperations $b): int
    {
        return $b->getDate() <=> $a->getDate();
    }

    /**
     * Compares operations by createdAt value, consider descending order.
     *
     * @param BaseOperation $a
     * @param BaseOperation $b
     *
     * @return integer
     */
    private function compareOperationsByCreatedAt(BaseOperation $a, BaseOperation $b): int
    {
        return $b->getCreatedAt() <=> $a->getCreatedAt();
    }
}
