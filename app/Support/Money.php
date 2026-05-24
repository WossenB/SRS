<?php

namespace App\Support;

class Money
{
    /**
     * Rounding Policy: Central App\Support\Money:
     * tax = HALF_DOWN, net/pension = HALF_UP.
     * All monetary fields DECIMAL(15,2).
     */

    public static function roundTax(float|string $amount): float
    {
        return round((float)$amount, 2, PHP_ROUND_HALF_DOWN);
    }

    public static function roundNet(float|string $amount): float
    {
        return round((float)$amount, 2, PHP_ROUND_HALF_UP);
    }

    public static function roundPension(float|string $amount): float
    {
        return round((float)$amount, 2, PHP_ROUND_HALF_UP);
    }

    public static function format(float|string $amount): string
    {
        return number_format((float)$amount, 2, '.', '');
    }
}
