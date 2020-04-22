<?php

namespace App\ValueObject;

use App\Entity\Obligation\Debt;
use DateTimeInterface;

class DebtDate
{
    /** @var Debt */
    private $debt;

    /** @var DateTimeInterface */
    private $date;

    /**
     * DebtDate constructor.
     *
     * @param Debt              $debt
     * @param DateTimeInterface $date
     */
    public function __construct(Debt $debt, DateTimeInterface $date)
    {
        $this->debt = $debt;
        $this->date = $date;
    }

    /**
     * @return Debt
     */
    public function getDebt(): Debt
    {
        return $this->debt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}
