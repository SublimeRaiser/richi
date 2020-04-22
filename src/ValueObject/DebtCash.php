<?php

namespace App\ValueObject;

use App\Entity\Obligation\Debt;

class DebtCash
{
    /** @var Debt */
    private $debt;

    /** @var integer */
    private $value;

    /**
     * DebtCash constructor.
     *
     * @param Debt    $debt
     * @param integer $value
     */
    public function __construct(Debt $debt, int $value)
    {
        $this->debt  = $debt;
        $this->value = $value;
    }

    /**
     * @return Debt
     */
    public function getDebt(): Debt
    {
        return $this->debt;
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
