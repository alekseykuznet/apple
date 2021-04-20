<?php

namespace app\helpers;

/**
 * Class DateTimeHelper
 * @package app\helpers
 */
class DateTimeHelper
{
    const MINUTE_SECONDS = 60;
    const HOUR_SECONDS = 3600;
    const DAY_SECONDS = 86400;
    const ONE_DAY_DIFF = 1;
    const NOW = 'now';

    public const DEFAULT_DATE_DOT_FORMAT = 'd.m.Y';
    public const DEFAULT_DATETIME_DOT_FORMAT = 'd.m.Y H:i:s';
    public const DEFAULT_DATETIME_DOT_FORMAT_WO_SEC = 'd.m.Y H:i';
    public const DEFAULT_DATE_FORMAT_VIEW = 'DD.MM.YYYY';
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';
    const DEFAULT_DATE_FORMAT = 'Y-m-d';
    const DATETIME_TIMEZONE_FORMAT = 'Y-m-d H:i:sP';
    const DATETIME_MONTH_DAY_FORMAT = 'm.d';
    const DATETIME_HOUR_MINUTE_FORMAT = 'H:i';
    const DATETIME_HOUR_BEGIN = 'Y-m-d H:00:00';
    const DATETIME_MONTH_BEGIN = 'first day of this month';

    const MONTH_INTERVAL = 'P1M';
    const DAY_INTERVAL = 'P1D';
    const WEEK_INTERVAL = 'P7D';

    /**
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function beginDayDateTimeFormattedFromString(string $time, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))
            ->setTime(0, 0)
            ->format($format);
    }

    /**
     * Converting the date and time to the beginning of the hour
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function asBeginHour(string $time, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))
            ->setTime((new \DateTime($time))->format('G'), 0, 0)
            ->format($format);
    }

    /**
     * Converting the date and time to the end of the hour
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function asEndHour(string $time, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))
            ->setTime((new \DateTime($time))->format('G'), 59, 59)
            ->format($format);
    }

    /**
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function endDayDateTimeFormatted(string $time, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))
            ->setTime(23, 59, 59)
            ->format($format);
    }

    /**
     * Alter timestamp
     *  ```php
     *  <?php echo DateTimeHelper::modify('2018-09-01 23:54:02', '+10 days'); // result 2018-09-11 23:59:59 ?>
     *  ```
     * @param string $time
     * @param string $interval
     * @param string $format
     * @return string
     */
    public static function modify(string $time, string $interval, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))->modify($interval)->format($format);
    }

    /**
     * Alter timestamp add datetime
     *  ```php
     *  <?php echo DateTimeHelper::add('2018-09-01 23:54:02', 'P1D'); // result 2018-09-02 23:54:02 ?>
     *  ```
     * Interval format
     * P - Date period
     * T - Time period
     * Y - Years
     * D - Days
     * M - Months
     * H - Hours
     * S - Seconds
     *
     * P10D - 10 days
     * P10DT10H 10 days + 10 hours
     *
     * @param string $time
     * @param string $interval
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function add(string $time, string $interval, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))->add(new \DateInterval($interval))->format($format);
    }

    /**
     * Alter timestamp sub datetime
     *  ```php
     *  <?php echo DateTimeHelper::sub('2018-09-02 23:54:02', 'P1D'); // result 2018-09-01 23:54:02 ?>
     *  ```
     * Interval format
     * P - Date period
     * T - Time period
     * Y - Years
     * D - Days
     * M - Months
     * H - Hours
     * S - Seconds
     *
     * P10D - 10 days
     * P10DT10H 10 days + 10 hours
     *
     * @param string $time
     * @param string $interval
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function sub(string $time, string $interval, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))->sub(new \DateInterval($interval))->format($format);
    }

    /**
     * @param string $time1
     * @param string $time2
     * @return null|string
     */
    public static function diffDays(string $time1, string $time2):? string
    {
        $interval = static::diff($time1, $time2);
        if ($interval !== null) {
            return (int)$interval->days;
        }
        return null;
    }

    /**
     * @param string $time1
     * @param string $time2
     * @return \DateInterval|null
     */
    public static function diff(string $time1, string $time2):? \DateInterval
    {
        $datetime1 = new \DateTime($time1);
        $datetime2 = new \DateTime($time2);
        $interval = $datetime1->diff($datetime2);
        if ($interval instanceof \DateInterval) {
            return $interval;
        }
        return null;
    }

    /**
     * create datetime with the specified format
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function create(string $time, string $format = self::DEFAULT_DATETIME_FORMAT): string
    {
        return (new \DateTime($time))->format($format);
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $format
     * @param string $interval
     * @return array
     */
    public static function getPeriod(string $dateStart, string $dateEnd, string $format = self::DEFAULT_DATETIME_FORMAT, string $interval = self::DAY_INTERVAL): array
    {
        $period = new \DatePeriod(
            new \DateTime($dateStart),
            new \DateInterval($interval),
            new \DateTime($dateEnd)
        );

        $result = [];

        foreach ($period as $value) {
            $result[] = $value->format($format);
        }

        return $result;
    }
}

