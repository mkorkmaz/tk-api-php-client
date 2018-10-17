<?php
declare(strict_types=1);

namespace TK\SDK\Helper;

/**
 * Class DurationConverter
 * @package TK\SDK\Helper
 *
 * Converts ISO 8601 formatted duration
 */
class DurationConverter
{
    public static function toSeconds(string $duration) : float
    {
        preg_match('/^P(.*?)Y(.*?)M(.*?)DT(.*?)H(.*?)M(.*?)S$/', $duration, $matches);

        list ($ignore, $year, $month, $day, $hour, $minute, $second) = array_map(function ($item) {
            return (float) $item;
        }, $matches);

        $seconds = $year * 365 * 24 * 60 * 60
            + $month * 30 * 24 * 60 * 60
            + $day * 24 * 60 * 60
            + $hour * 60 * 60
            + $minute * 60
            + $second
        ;
        return $seconds;
    }

    public static function toMinute(string $duration) : float
    {
        return self::toSeconds($duration) / 60;
    }
    public static function toHour(string $duration) : float
    {
        return self::toMinute($duration) / 60;
    }

    public static function toDay(string $duration) : float
    {
        return self::toHour($duration) / 24;
    }

    public static function toMonth(string $duration) : float
    {
        return self::toDay($duration) / 30;
    }

    public static function toYear(string $duration) : float
    {
        return round(self::toDay($duration) / 365, 2);
    }
}
