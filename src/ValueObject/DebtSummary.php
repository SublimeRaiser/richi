<?php

namespace App\ValueObject;

use App\Entity\Obligation\Debt;
use DateTimeInterface;

class DebtSummary
{
    /** @var Debt */
    private $debt;

    /** @var DateTimeInterface */
    private $date;

    /** @var integer */
    private $amount;

    /** @var integer */
    private $repayment;

    /** @var integer */
    private $relief;

    /** @var integer */
    private $remaining;

    /**
     * DebtSummary constructor.
     *
     * @param Debt              $debt
     * @param DateTimeInterface $date
     * @param integer           $amount
     * @param integer           $repayment
     * @param integer           $relief
     * @param integer           $remaining
     */
    public function __construct(
        Debt $debt,
        DateTimeInterface $date,
        int $amount,
        int $repayment,
        int $relief,
        int $remaining
    ) {
        $this->debt      = $debt;
        $this->date      = $date;
        $this->amount    = $amount;
        $this->repayment = $repayment;
        $this->relief    = $relief;
        $this->remaining = $remaining;
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

    /**
     * @return integer
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return integer
     */
    public function getRepayment(): int
    {
        return $this->repayment;
    }

    /**
     * @return integer
     */
    public function getRelief(): int
    {
        return $this->relief;
    }

    /**
     * @return integer
     */
    public function getRemaining(): int
    {
        return $this->remaining;
    }
}
