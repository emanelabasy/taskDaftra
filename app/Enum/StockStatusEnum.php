<?php

namespace App\Enum;

enum StockStatusEnum: int
{
    case PENDING   = 1;
    case APPROVED  = 2;
    case REJECTED  = 3;
    case COMPLETED = 4;

    public static function getForSelect(): array
    {
        return [
            self::PENDING->value   => 'pending',
            self::APPROVED->value  => 'approved',
            self::REJECTED->value  => 'rejected',
            self::COMPLETED->value => 'completed',
        ];
    }

    public static function getValues(): array
    {
        return [
            self::PENDING->value,
            self::APPROVED->value,
            self::REJECTED->value,
            self::COMPLETED->value,
        ];
    }

}