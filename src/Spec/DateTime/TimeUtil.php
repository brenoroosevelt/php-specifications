<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @method static int year($date = null)
 * @method static int yearIso($date = null)
 * @method static int month($date = null)
 * @method static int day($date = null)
 * @method static int hour($date = null)
 * @method static int minute($date = null)
 * @method static int second($date = null)
 * @method static int microsecond($date = null)
 * @method static int time($date = null)
 * @method static int dayOfWeek($date = null)
 * @method static int dayOfYear($date = null)
 * @method static int weekOfYear($date = null)
 * @method static int daysInMonth($date = null)
 * @method static int timestamp($date = null)
 * @method static int birthday($date = null)
 * @method static int date($date = null)
 * @method static int quarterOfYear($date = null)
 * @method static int halfOfYear($date = null)
 * @method static int lastYear($date = null)
 * @method static int nextYear($date = null)
 * @method static int nextMonth($date = null)
 * @method static int lastMonth($date = null)
 *
 * @method static bool isLeapYear($date = null)
 * @method static bool isWeekday($date = null)
 * @method static bool isWeekend($date = null)
 * @method static bool isMonday($date = null)
 * @method static bool isTuesday($date = null)
 * @method static bool isWednesday($date = null)
 * @method static bool isThursday($date = null)
 * @method static bool isFriday($date = null)
 * @method static bool isSaturday($date = null)
 * @method static bool isSunday($date = null)
 * @method static bool isFirstHalfOfYear($date = null)
 * @method static bool isSecondHalfOfYear($date = null)
 * @method static bool isToday($date)
 * @method static bool isYesterday($date)
 * @method static bool isTomorrow($date)
 * @method static bool isLastDayOfMonth($date = null)
 * @method static bool isLastDayOfYear($date = null)
 * @method static bool isFirstDayOfYear($date = null)
 * @method static bool isFirstDayOfMonth($date = null)
 * @method static bool isAM($date = null)
 * @method static bool isPM($date = null)
 * @method static bool isMidway($date = null)
 * @method static bool isMidnight($date = null)
 * @method static bool isEndOfDay($date = null)
 * @method static bool isStartOfDay($date = null)
 *
 * @method static bool sameYear($d1, $d2 = null)
 * @method static bool sameMonth($d1, $d2 = null, bool $ofSameYear = true)
 * @method static bool sameDay($d1, $d2 = null)
 * @method static bool sameYearIso($d1, $d2 = null)
 * @method static bool sameHour($d1, $d2 = null)
 * @method static bool sameMinute($d1, $d2 = null)
 * @method static bool sameSecond($d1, $d2 = null)
 * @method static bool sameMicrosecond($d1, $d2 = null)
 * @method static bool sameTime($d1, $d2 = null)
 * @method static bool sameDayOfWeek($d1, $d2 = null)
 * @method static bool sameDayOfYear($d1, $d2 = null, bool $ofSameYear = true)
 * @method static bool sameWeekOfYear($d1, $d2 = null, bool $ofSameYear = true)
 * @method static bool sameDaysInMonth($d1, $d2 = null)
 * @method static bool sameTimestamp($d1, $d2 = null)
 * @method static bool sameBirthday($d1, $d2 = null, bool $ofSameYear = true)
 * @method static bool sameDate($d1, $d2 = null)
 * @method static bool sameQuarterOfYear($d1, $d2 = null, bool $ofSameYear = true)
 * @method static bool sameHalfOfYear($d1, $d2 = null, bool $ofSameYear = true)
 */
class TimeUtil
{
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
    const Sunday = 7;

    protected static $now = 'now';
    protected static $nowTz = null;

    public static $formats = [
        'year' => 'Y',
        'yearIso' => 'o',
        'month' => 'n',
        'day' => 'j',
        'hour' => 'G',
        'minute' => 'i',
        'second' => 's',
        'microsecond' => 'u',
        'dayOfWeek' => 'N',
        'dayOfYear' => 'z',
        'weekOfYear' => 'W',
        'daysInMonth' => 't',
        'timestamp' => 'U',
        'date' => 'Ymd',
        'birthday' => 'md', // move
        'time' => 'His', // move
    ];

    public static function setNow($now, $tz = null)
    {
        self::$now = $now ?? 'now';
        self::$nowTz = $tz;
    }

    public static function resetNow()
    {
        self::$now = null;
        self::$nowTz = null;
    }

    public static function now($tz = null): DateTimeImmutable
    {
        return new DateTimeImmutable(self::$now, $tz ?? self::$nowTz);
    }

    public static function nowMutable($tz = null): DateTime
    {
        return new DateTime(self::$now, $tz ?? self::$nowTz);
    }

    public static function today($tz = null): DateTimeImmutable
    {
        return self::now($tz)->setTime(0, 0, 0,0);
    }

    public static function tomorrow($tz = null): DateTimeImmutable
    {
        return self::now($tz)->setTime(0, 0, 0,0)->modify('+1 days');
    }

    public static function yesterday($tz = null): DateTimeImmutable
    {
        return self::now($tz)->setTime(0, 0, 0,0)->modify('-1 days');
    }

    public static function endOfDay($date = null): DateTimeImmutable
    {
        return self::immutable($date)->setTime(23, 59, 59, 999999);
    }

    public static function startOfDay($date = null): DateTimeImmutable
    {
        return self::immutable($date)->setTime(0, 0, 0, 0);
    }

    public static function startOfWeek($date = null, int $startOfWeek = self::Monday): DateTimeImmutable
    {
        $dateTime = self::immutable($date);
        var_dump(self::dayOfWeek($dateTime));
        if (self::dayOfWeek($dateTime) !== $startOfWeek) {
            $dayOfWeekName = self::weeks()[$startOfWeek];
            $dateTime = $dateTime->modify("last $dayOfWeekName");
        }

        return self::startOfDay($dateTime);
    }

    public static function endOfWeek($date = null, int $endOfWeek = self::Sunday): DateTimeImmutable
    {
        $dateTime = self::immutable($date);
        if (self::dayOfWeek($dateTime) !== $endOfWeek) {
            $dayOfWeekName = self::weeks()[$endOfWeek];
            $dateTime = $dateTime->modify("next $dayOfWeekName");
        }

        return self::endOfDay($dateTime);
    }

    public static function startOfMonth($date = null): DateTimeImmutable
    {
        $dateTime = self::immutable($date);
        $dateTime =
            $dateTime->setDate(
                (int) $dateTime->format('Y'),
                (int) $dateTime->format('m'),
                1
            );

        return self::startOfDay($dateTime);
    }

    public static function endOfMonth($date = null): DateTimeImmutable
    {
        $dateTime = self::immutable($date);
        $dateTime =
            $dateTime->setDate(
                (int) $dateTime->format('Y'),
                (int) $dateTime->format('m'),
                (int) $dateTime->format('t')
            );

        return self::endOfDay($dateTime);
    }

    public static function startOfYear($dateOrYear = null): DateTimeImmutable
    {
        if (is_integer($dateOrYear)) {
            $date = self::immutable("$dateOrYear-01-01");
        } else {
            $date = self::immutable($dateOrYear);
            $date =
                $date->setDate(
                    (int) $date->format('Y'),
                    1,
                    1
                );
        }

        return self::startOfDay($date);
    }

    public static function endOfYear($dateOrYear = null): DateTimeImmutable
    {
        if (is_integer($dateOrYear)) {
            $date = self::immutable("$dateOrYear-12-31");
        } else {
            $date = self::immutable($dateOrYear);
            $date =
                $date->setDate(
                    (int) $date->format('Y'),
                    12,
                    31
                );
        }

        return self::endOfDay($date);
    }

    public static function __callStatic($name, $arguments)
    {
        $date = self::immutable(array_shift($arguments));

        if (isset(self::$formats[$name])) {
            $format = self::$formats[$name];
            return (int) $date->format($format);
        }

        switch ($name) {
            case 'quarterOfYear':
                return (int) ceil(self::month($date) / 3);

            case 'halfOfYear':
                return (int) ceil(self::month($date) / 6);

            case 'isFirstHalfOfYear':
                return self::halfOfYear($date) === 1;

            case 'isSecondHalfOfYear':
                return self::halfOfYear($date) === 2;

            case 'isLeapYear':
                return $date->format('L') === 1;

            case 'isWeekday':
                return self::dayOfWeek($date) <= 5;

            case 'isWeekend':
                return self::dayOfWeek($date) > 5;

            case 'isSunday':
                return self::dayOfWeek($date) === self::Sunday;

            case 'isMonday':
                return self::dayOfWeek($date) === self::Monday;

            case 'isTuesday':
                return self::dayOfWeek($date) === self::Tuesday;

            case 'isWednesday':
                return self::dayOfWeek($date) === self::Wednesday;

            case 'isThursday':
                return self::dayOfWeek($date) === self::Thursday;

            case 'isFriday':
                return self::dayOfWeek($date) === self::Friday;

            case 'isSaturday':
                return self::dayOfWeek($date) === self::Saturday;

            case 'isToday':
                return self::sameDate($date, self::today());

            case 'isYesterday':
                return self::sameDate($date, self::yesterday());

            case 'isTomorrow':
                return self::sameDate($date, self::tomorrow());

            case 'isFirstDayOfMonth':
                return self::day($date) === 1;

            case 'isLastDayOfMonth':
                return self::day($date) === self::daysInMonth($date);

            case 'isFirstDayOfYear':
                return $date->format('dm') === '0101';

            case 'isLastDayOfYear':
                return $date->format('dm') === '1231';

            case 'isAM':
                return $date->format('a') === 'am';

            case 'isPM':
                return $date->format('a') === 'pm';

            case 'isMidway':
                return $date->format('H:i:s') === '12:00:00';

            case 'isEndOfDay':
                return $date->format('H:i:s') === '23:59:59';

            case 'isStartOfDay':
            case 'isMidnight':
                return $date->format('H:i:s') === '00:00:00';

            case 'lastMonth':
                $month = self::month($date);
                return $month === 1 ? 12 : $month - 1;

            case 'nextMonth':
                $month = self::month($date);
                return $month === 12 ? 1 : $month + 1;

            case 'nextYear':
                return self::year($date) + 1;

            case 'lastYear':
                return self::year($date) - 1;
        }

        if (stripos($name, 'same') === 0 && strlen($name) > 4) {
            $_name = lcfirst(substr($name, 4));
            $date2 = self::immutable(array_shift($arguments));
            $arg3 = array_shift($arguments);
            $ofSameYear = $arg3 === null ? true : $arg3;

            $year1 = $ofSameYear ? self::year($date) : null;
            $year2 = $ofSameYear ? self::year($date2): null;
            $result1 = forward_static_call_array([__CLASS__, $_name], [$date]);
            $result2 = forward_static_call_array([__CLASS__, $_name], [$date2]);

            return $result1 === $result2 && $year1 === $year2;
        }

        return null;
    }

    public static function isBefore($before, $date): bool
    {
        return self::immutable($date) < self::immutable($before);
    }

    public static function isAfter($after, $date): bool
    {
        return self::immutable($date) > self::immutable($after);
    }

    public static function isPast($date): bool
    {
        return self::isBefore(self::now(), $date);
    }

    public static function isFuture($date): bool
    {
        return self::isAfter(self::now(), $date);
    }

    public static function isBetween($initial, $final, $date = null, bool $boundaries = true): bool
    {
        $dt = self::immutable($date);
        $i = self::immutable($initial);
        $f = self::immutable($final);

        return $boundaries ? $dt >= $i && $dt <= $f : $dt > $i && $dt < $f;
    }

    public static function isBeforeToday($date): bool
    {
        return self::isBefore(self::today(), $date);
    }

    public static function isAfterToday($date): bool
    {
        return self::isAfter(self::endOfDay(self::today()), $date);
    }

    public static function isBeforeYesterday($date): bool
    {
        return self::isBefore(self::yesterday(), $date);
    }

    public static function isAfterYesterday($date): bool
    {
        return self::isAfter(self::endOfDay(self::yesterday()), $date);
    }

    public static function isAfterTomorrow($date): bool
    {
        return self::isAfter(self::endOfDay(self::tomorrow()), $date);
    }

    public static function isBeforeTomorrow($date): bool
    {
        return self::isBefore(self::tomorrow(), $date);
    }

    public static function isWorkday(
        $date = null,
        array $holidays = [],
        array $weekend = [TimeUtil::Saturday, TimeUtil::Sunday]
    ): bool {
        $dateTime = self::immutable($date);
        $dayOfWeek = self::dayOfWeek($dateTime);

        if (in_array($dayOfWeek, $weekend)) {
            return false;
        }

        foreach ($holidays as $holiday) {
            if (self::sameDate($dateTime, $holiday)) {
                return false;
            }
        }

        return true;
    }

    public static function nextWorkday(
        $begin = null,
        array $holidays = [],
        array $weekend = [TimeUtil::Saturday, TimeUtil::Sunday]
    ): DateTimeImmutable {
        $dateTime = self::immutable($begin);
        $workingDate = self::immutable($dateTime);
        while (!self::isWorkday($workingDate, $holidays, $weekend)){
            $workingDate = $workingDate->modify('+1 days');
        }

        return $workingDate;
    }

    public static function monthly(int $count, int $day = null, $beginDate = null, $overflow = false): array
    {
        $date = self::startOfMonth($beginDate);
        $year = (int) $date->format('Y');
        $month = (int) $date->format('m');
        $day = $day ?? OldDateTime::day();

        $result = [];
        while (count($result) < $count) {
            $daysInMonth = self::daysInMonth("$year-$month");
            $newDay = !$overflow && $day > $daysInMonth ? $daysInMonth : $day;
            $result["$year-$month"] = $date = $date->setDate($year, $month, $newDay);

            if ($month === 12) {
                $year++;
                $month = 1;
            } else {
                $month++;
            }
        }

        return $result;
    }

    public static function weeks(): array
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
    }

    public static function dayOfWeekName($date = null): string
    {
        return self::weeks()[self::dayOfWeek($date)];
    }

    public static function weekly(int $count, int $dayOfWeek = null, $beginDate = null): array
    {
        $weekName = self::weeks()[$dayOfWeek] ?? self::dayOfWeekName();
        $date = self::immutable($beginDate);
        $result = [];

        if (self::dayOfWeekName($date) === $weekName) {
            $result[] = $date;
        }

        while (count($result) < $count) {
           $time = strtotime("next $weekName", $date->getTimestamp());
           $result[] = $date = $date->setTimestamp($time);
        }

        return $result;
    }

    public static function daily(int $count, $beginDate = null, array $except = []): array
    {
        $date = self::immutable($beginDate);
        $result[] = $date;
        $except = array_map(
            function ($dt) {
                return self::immutable($dt)->format('Y-m-d');
            },
            $except
        );

        while (count($result) < $count) {
            $date = $date->modify('+1 day');
            $current = $date->format('Y-m-d');
            if (!in_array($current, $except)) {
                $result[] = $date;
            }
        }

        return $result;
    }

    public static function format($date = null, string $format = DATE_ISO8601): string
    {
        return self::immutable($date)->format($format);
    }

    public static function formatAll(array $date = [], string $format = DATE_ISO8601): array
    {
        return array_map(
            function ($date) use ($format) {
                return self::immutable($date)->format($format);
            },
            $date
        );
    }

    public static function modify(string $modify, $date = null): DateTimeImmutable
    {
        return self::immutable($date)->modify($modify);
    }

    public static function modifyAll(string $modify, array $date): array
    {
        return
            array_map(
                function ($dt) use ($modify) {
                    return self::modify($modify, $dt);
                },
                $date
            );
    }

    public static function immutable($dateTime = null, $tz = null): DateTimeImmutable
    {
        if ($dateTime === null) {
            return self::now($tz);
        }

        if ($dateTime instanceof DateTimeInterface) {
            $new = DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s.u',
                $dateTime->format('Y-m-d H:i:s.u')
            );

            if (false !== ($tz = $dateTime->getTimezone())) {
                $new = $new->setTimezone($tz);
            }

            return $new;
        }

        return new DateTimeImmutable($dateTime, $tz ?? self::$nowTz);
    }

    public static function mutable($dateTime = null, $tz = null): DateTime
    {
        if ($dateTime === null) {
            return self::nowMutable($tz);
        }

        if ($dateTime instanceof DateTimeInterface) {
            $new = DateTime::createFromFormat(
                'Y-m-d H:i:s.u',
                $dateTime->format('Y-m-d H:i:s.u')
            );

            if (false !== ($tz = $dateTime->getTimezone())) {
                $new = $new->setTimezone($tz);
            }

            return $new;
        }

        return new DateTime($dateTime, $tz ?? self::$nowTz);
    }

    public static function decade($date = null): int
    {
        $year = (self::immutable($date))->format('y');
        return (int) floor($year / 10);
    }

    public static function century($date = null): int
    {
        $year = (string) self::year($date);
        $century = (int) substr_replace($year, '', -2);
        return (int) substr($year, -2) === '00' ? $century : $century + 1;
    }

    public static function centuryInRomanNumerals($date = null): string
    {
        return self::toRomanNumerals(self::century($date));
    }

    public static function toRomanNumerals(int $number):string
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }

        return $returnValue;
    }

    protected static function cyclicBetween(int $i, int $f, int $value, bool $boundaries = true): bool
    {
        if ($i > $f) {
            return
                $boundaries ?
                    $value >= $i || $value <= $f :
                    $value > $i || $value < $f ;
        }

        return
            $boundaries ?
                $value >= $i && $value <= $f :
                $value > $i && $value < $f ;
    }

    public static function monthBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        $month = self::month($date);
        return self::cyclicBetween($i, $f, $month, $boundaries);
    }

    public static function dayBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        $day = self::day($date);
        return self::cyclicBetween($i, $f, $day, $boundaries);
    }

    public static function dayOfWeekBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        $dayOfWeek = self::dayOfWeek($date);
        return self::cyclicBetween($i, $f, $dayOfWeek, $boundaries);
    }

    public static function timeBetween(string $i, string $f, $date = null, bool $boundaries = true): bool
    {
        $t = self::immutable($date)->format('H:i:s');
        $ti = self::immutable($i)->format('H:i:s');
        $tf = self::immutable($f)->format('H:i:s');

        list($ht, $mt, $st) = explode(':', $t);
        list($hi, $mi, $si) = explode(':', $ti);
        list($hf, $mf, $sf) = explode(':', $tf);

        $total_t = ($ht * 60 * 60) + ($mt * 60) + $st;
        $total_i = ($hi * 60 * 60) + ($mi * 60) + $si;
        $total_f = ($hf * 60 * 60) + ($mf * 60) + $sf;

        return self::cyclicBetween($total_i, $total_f, $total_t, $boundaries);
    }
}
