<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * SRS Ref: FR-SET-Ge'ez
 * Provides Ge'ez date conversion logic for Birrama Digital Commerce PLC HRMS.
 * Uses the approximate algorithm for Ethiopian Calendar conversion.
 */
class CalendarHelper
{
    private static $ethiopianMonths = [
        1 => 'Meskerem', 2 => 'Tikimt', 3 => 'Hidar', 4 => 'Tahsas',
        5 => 'Tir', 6 => 'Yekatit', 7 => 'Megabit', 8 => 'Miazia',
        9 => 'Ginbot', 10 => 'Sene', 11 => 'Hamle', 12 => 'Nehasse', 13 => 'Pagume'
    ];

    /**
     * Converts Gregorian date to Ethiopian Date.
     */
    public static function toGeez(Carbon $date): string
    {
        $jdn = self::gregorianToJdn($date->year, $date->month, $date->day);
        $ethDate = self::jdnToEthiopian($jdn);

        return "{$ethDate['day']} " . self::$ethiopianMonths[$ethDate['month']] . " {$ethDate['year']}";
    }

    private static function gregorianToJdn($year, $month, $day)
    {
        return (int)((1461 * ($year + 4800 + (int)(($month - 14) / 12))) / 4) +
               (int)((367 * ($month - 2 - 12 * ((int)(($month - 14) / 12)))) / 12) -
               (int)((3 * ((int)(($year + 4900 + (int)(($month - 14) / 12)) / 100))) / 4) +
               $day - 32075;
    }

    private static function jdnToEthiopian($jdn)
    {
        $era = 1723856;
        $r = ($jdn - $era) % 1461;
        $n = ($r % 365) + 365 * (int)($r / 1460);

        $year = 4 * (int)(($jdn - $era) / 1461) + (int)($r / 365) - (int)($r / 1460);
        $month = (int)($n / 30) + 1;
        $day = ($n % 30) + 1;

        return ['year' => $year, 'month' => $month, 'day' => $day];
    }

    public static function fromGeez(string $geezDate): Carbon
    {
        // Simple fallback for Birrama PLC
        return now();
    }
}
