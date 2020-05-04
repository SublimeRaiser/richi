<?php

namespace App\Enum;

/**
 * Class OperationTypeEnum
 * @package App\Enum
 */
final class OperationTypeEnum
{
    const TYPE_INCOME          = 1;
    const TYPE_EXPENSE         = 2;
    const TYPE_TRANSFER        = 3;
    const TYPE_DEBT            = 4;
    const TYPE_REPAYMENT       = 5;
    const TYPE_DEBT_RELIEF     = 6;
    const TYPE_LOAN            = 7;
    const TYPE_DEBT_COLLECTION = 8;
    const TYPE_LOAN_RELIEF     = 9;

    /** @var array User friendly named type */
    private static $typeNames = [
        self::TYPE_INCOME          => 'income',
        self::TYPE_EXPENSE         => 'expense',
        self::TYPE_TRANSFER        => 'transfer',
        self::TYPE_DEBT            => 'debt',
        self::TYPE_REPAYMENT       => 'repayment',
        self::TYPE_DEBT_RELIEF     => 'debt relief',
        self::TYPE_LOAN            => 'loan',
        self::TYPE_DEBT_COLLECTION => 'debt collection',
        self::TYPE_LOAN_RELIEF     => 'loan relief',
    ];

    /**
     * Returns user friendly name for the provided operation type.
     *
     * @param integer $type
     *
     * @return string|null
     */
    public static function getName(int $type): ?string
    {
        return self::$typeNames[$type] ?? null;
    }

    /**
     * Returns an array of all the available operation types.
     *
     * @return array
     */
    public static function getAvailableTypes(): array
    {
        return array_keys(self::$typeNames);
    }
}
