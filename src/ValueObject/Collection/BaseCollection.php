<?php

namespace App\ValueObject\Collection;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

abstract class BaseCollection implements IteratorAggregate
{
    /** @var array */
    protected $elements;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

}
