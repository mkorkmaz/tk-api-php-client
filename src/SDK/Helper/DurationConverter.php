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
    const FORMAT_LONG = 'l';
    const FORMAT_SHORT = 's';

    public static function getDateTimeParts(string $duration, $format) : array
    {
        if ($format === 'l') {
            preg_match('/^P(.*?)Y(.*?)M(.*?)DT(.*?)H(.*?)M(.*?)S$/', $duration, $matches);
            [$ignore, $year, $month, $day, $hour, $minute, $second] = array_map(function ($item) {
                return (float) $item;
            }, $matches);
        }

        if ($format === 's') {
            preg_match('/^P(.*?)DT(.*?)H(.*?)M(.*?)S$/', $duration, $matches);
            [$ignore, $day, $hour, $minute, $second] = array_map(function ($item) {
                return (float) $item;
            }, $matches);
            $year = 0;
            $month = 0;
        }
        return [$year, $month, $day, $hour, $minute, $second];
    }

    public static function toSeconds(string $duration, ?string $format = 'l') : float
    {
        list($year, $month, $day, $hour, $minute, $second) = self::getDateTimeParts($duration, $format);
        $seconds = $year * 365 * 24 * 60 * 60
            + $month * 30 * 24 * 60 * 60
            + $day * 24 * 60 * 60
            + $hour * 60 * 60
            + $minute * 60
            + $second
        ;
        return $seconds;
    }

    public static function toMinute(string $duration, ?string $format = 'l') : float
    {
        return self::toSeconds($duration, $format) / 60;
    }
    public static function toHour(string $duration, ?string $format = 'l') : float
    {
        return self::toMinute($duration, $format) / 60;
    }

    public static function toDay(string $duration, ?string $format = 'l') : float
    {
        return self::toHour($duration, $format) / 24;
    }

    public static function toMonth(string $duration, ?string $format = 'l') : float
    {
        return self::toDay($duration, $format) / 30;
    }

    public static function toYear(string $duration, ?string $format = 'l') : float
    {
        return round(self::toDay($duration, $format) / 365, 2);
    }
}
