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
    public const FORMAT_LONG = 'l';
    public const FORMAT_SHORT = 's';

    public static function getDateTimeParts(string $duration, $format) : array
    {
        if ($format === 'l') {
            preg_match('/^P(.*?)Y(.*?)M(.*?)DT(.*?)H(.*?)M(.*?)S$/', $duration, $matches);
            [, $year, $month, $day, $hour, $minute, $second] = array_map(function ($item) {
                return (float) $item;
            }, $matches);
            return [$year, $month, $day, $hour, $minute, $second];
        }
        preg_match('/^P(.*?)DT(.*?)H(.*?)M(.*?)S$/', $duration, $matches);
        [, $day, $hour, $minute, $second] = array_map(function ($item) {
            return (float) $item;
        }, $matches);
        return [0, 0, $day, $hour, $minute, $second];
    }

    public static function toSeconds(string $duration, ?string $format = 'l') : float
    {
        [$year, $month, $day, $hour, $minute, $second] = self::getDateTimeParts($duration, $format);
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
        return round(self::toDay($duration, $format) / 30, 2);
    }

    public static function toYear(string $duration, ?string $format = 'l') : float
    {
        return round(self::toDay($duration, $format) / 365, 2);
    }
}
