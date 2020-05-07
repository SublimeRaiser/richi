<?php

namespace App\ValueObject\Collection;

use App\Entity\Account;

class AccountCollection extends BaseCollection
{
    /**
     * AccountCollection constructor.
     *
     * @param Account ...$elements
     */
    public function __construct(Account ...$elements)
    {
        $this->elements = $elements;
    }
}
