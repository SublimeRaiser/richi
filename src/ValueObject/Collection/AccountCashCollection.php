<?php

namespace App\ValueObject\Collection;

use App\ValueObject\AccountCash;

class AccountCashCollection extends BaseCollection
{
    /**
     * AccountCashCollection constructor.
     *
     * @param AccountCash ...$elements
     */
    public function __construct(AccountCash ...$elements)
    {
        $this->elements = $elements;
    }
}
