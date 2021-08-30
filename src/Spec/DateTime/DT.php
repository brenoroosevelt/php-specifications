<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec\DateTime;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class DT
{
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
    const Sunday = 7;

    const January = 1;
    const February  = 2;
    const March = 3;
    const April = 4;
    const May = 5;
    const June = 6;
    const July = 7;
    const August = 8;
    const September = 9;
    const October = 10;
    const November = 11;
    const December = 12;

    const StartOfDay = '00:00:00';
    const EndOfDay = '23:59:59';
    const Midday = '12:00:00';
    const Midnight = '00:00:00';

    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;
    const MICROS_PER_SECOND = 1000000;

    const FIRST_MONTH = 1;
    const MONTHS_PER_YEAR = 12;

    public static $weekend = [
        self::Saturday,
        self::Sunday
    ];

    protected static $now = 'now';
    protected static $nowTz = null;

    public static $formats = [
        'year' => 'Y',
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
        'birthday' => 'md',
        'time' => 'H:i:s',
    ];

    public static function setNow($now, $tz = null)
    {
        self::$now = $now ?? 'now';
        self::$nowTz = $tz;
    }

    public static function setWeekend(array $weekend)
    {
        self::$weekend = array_filter($weekend, 'is_integer');
    }

    public static function resetNow()
    {
        self::$now = 'now';
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

    public static function setTimeZone($tz)
    {
        self::$nowTz = new \DateTimeZone($tz);
    }

    public static function today($tz = null): DateTimeImmutable
    {
        return self::startOfDay(self::now($tz));
    }

    public static function tomorrow($tz = null): DateTimeImmutable
    {
        return self::startOfDay(self::now($tz)->modify('+1 days'));
    }

    public static function yesterday($tz = null): DateTimeImmutable
    {
        return self::startOfDay(self::now($tz)->modify('-1 days'));
    }

    public static function endOfDay($date = null): DateTimeImmutable
    {
        return
            self::immutable($date)
                ->setTime(
                    self::HOURS_PER_DAY - 1,
                    self::MINUTES_PER_HOUR - 1,
                    self::SECONDS_PER_MINUTE -1,
                    self::MICROS_PER_SECOND -1
                );
    }

    public static function startOfDay($date = null): DateTimeImmutable
    {
        return self::immutable($date)->setTime(0, 0, 0, 0);
    }

    public static function startOfWeek($date = null, int $startOfWeek = self::Monday): DateTimeImmutable
    {
        $dateTime = self::immutable($date);
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
        $dateTime = $dateTime->setDate((int) $dateTime->format('Y'), (int) $dateTime->format('m'), 1);
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
        $firstMonth = self::FIRST_MONTH;
        $firstDay = 1;
        if (is_integer($dateOrYear)) {
            $date = self::immutable("$dateOrYear-$firstMonth-$firstDay");
        } else {
            $date = self::immutable($dateOrYear);
            $date = $date->setDate((int) $date->format('Y'), $firstMonth, $firstDay);
        }

        return self::startOfDay($date);
    }

    public static function endOfYear($dateOrYear = null): DateTimeImmutable
    {
        $lastMonth = self::MONTHS_PER_YEAR;
        $lastDay = 31;
        if (is_integer($dateOrYear)) {
            $date = self::immutable("$dateOrYear-$lastMonth-$lastDay");
        } else {
            $date = self::immutable($dateOrYear);
            $date = $date->setDate((int) $date->format('Y'), $lastMonth, $lastDay);
        }

        return self::endOfDay($date);
    }

    public static function year($date = null): int
    {
        return (int) self::immutable($date)->format('Y');
    }

    public static function month($date = null): int
    {
        return (int) self::immutable($date)->format('n');
    }

    public static function day($date = null): int
    {
        return (int) self::immutable($date)->format('j');
    }

    public static function hour($date = null): int
    {
        return (int) self::immutable($date)->format('G');
    }

    public static function minute($date = null): int
    {
        return (int) self::immutable($date)->format('i');
    }

    public static function second($date = null): int
    {
        return (int) self::immutable($date)->format('s');
    }

    public static function microsecond($date = null): int
    {
        return (int) self::immutable($date)->format('u');
    }

    public static function micro($date = null): int
    {
        return (int) self::microsecond($date);
    }

    public static function dayOfWeek($date = null): int
    {
        return (int) self::immutable($date)->format('N');
    }

    public static function dayOfYear($date = null): int
    {
        return (int) self::immutable($date)->format('z');
    }

    public static function weekOfYear($date = null): int
    {
        return (int) self::immutable($date)->format('W');
    }

    public static function daysInMonth($date = null): int
    {
        return (int) self::immutable($date)->format('t');
    }

    public static function timestamp($date = null): int
    {
        return (int) self::immutable($date)->format('U');
    }

    public static function date($date = null): int
    {
        return (int) self::immutable($date)->format('Ymd');
    }

    public static function birthday($date = null): string
    {
        return self::immutable($date)->format('md');
    }

    public static function time($date = null, $micro = false): string
    {
        return self::immutable($date)->format($micro? 'H:i:s.u' : 'H:i:s');
    }

    public static function quarterOfYear($date = null): int
    {
        return (int) ceil(self::month($date) / 3);
    }

    public static function halfOfYear($date = null): int
    {
        return (int) ceil(self::month($date) / 6);
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

    public static function isFirstHalfOfYear($date = null): bool
    {
        return self::halfOfYear($date) === 1;
    }

    public static function isSecondHalfOfYear($date = null): bool
    {
        return self::halfOfYear($date) === 2;
    }

    public static function isLeapYear($date = null): bool
    {
        return $date->format('L') === 1;
    }

    public static function isWeekday($date = null): bool
    {
        return !self::isWeekend($date);
    }

    public static function isWeekend($date = null): bool
    {
        return in_array(self::dayOfWeek($date), self::$weekend);
    }

    public static function isSunday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Sunday;
    }

    public static function isMonday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Monday;
    }

    public static function isTuesday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Tuesday;
    }

    public static function isWednesday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Wednesday;
    }

    public static function isThursday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Thursday;
    }

    public static function isFriday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Friday;
    }

    public static function isSaturday($date = null): bool
    {
        return self::dayOfWeek($date) === self::Saturday;
    }

    public static function isJanuary($date = null): bool
    {
        return self::month($date) === self::January;
    }

    public static function isFebruary($date = null): bool
    {
        return self::month($date) === self::February;
    }

    public static function isMarch($date = null): bool
    {
        return self::month($date) === self::March;
    }

    public static function isApril($date = null): bool
    {
        return self::month($date) === self::April;
    }

    public static function isMay($date = null): bool
    {
        return self::month($date) === self::May;
    }

    public static function isJune($date = null): bool
    {
        return self::month($date) === self::June;
    }

    public static function isJuly($date = null): bool
    {
        return self::month($date) === self::July;
    }

    public static function isAugust($date = null): bool
    {
        return self::month($date) === self::August;
    }

    public static function isSeptember($date = null): bool
    {
        return self::month($date) === self::September;
    }

    public static function isOctober($date = null): bool
    {
        return self::month($date) === self::October;
    }

    public static function isNovember($date = null): bool
    {
        return self::month($date) === self::November;
    }

    public static function isDecember($date = null): bool
    {
        return self::month($date) === self::December;
    }

    public static function isToday($date = null): bool
    {
        return self::isSameDate($date, self::today());
    }

    public static function isYesterday($date = null): bool
    {
        return self::isSameDate($date, self::yesterday());
    }

    public static function isTomorrow($date = null): bool
    {
        return self::isSameDate($date, self::tomorrow());
    }

    public static function isFirstDayOfMonth($date = null): bool
    {
        return self::day($date) === 1;
    }

    public static function isLastDayOfMonth($date = null): bool
    {
        return self::day($date) === self::daysInMonth($date);
    }

    public static function isFirstDayOfYear($date = null): bool
    {
        return self::immutable($date)->format('dm') === '0101';
    }

    public static function isLastDayOfYear($date = null): bool
    {
        return self::immutable($date)->format('dm') === '1231';
    }

    public static function isAM($date = null): bool
    {
        return self::immutable($date)->format('a') === 'am';
    }

    public static function isPM($date = null): bool
    {
        return self::immutable($date)->format('a') === 'pm';
    }

    public static function isMidway($date = null): bool
    {
        return self::immutable($date)->format('H:i:s') === self::Midday;
    }

    public static function isEndOfDay($date = null): bool
    {
        return self::immutable($date)->format('H:i:s') === self::EndOfDay;
    }

    public static function isStartOfDay($date = null): bool
    {
        return self::immutable($date)->format('H:i:s') === self::StartOfDay;
    }

    public static function isMidnight($date = null): bool
    {
        return self::immutable($date)->format('H:i:s') === self::Midnight;
    }

    public static function isLastMonthOfYear($date = null): bool
    {
        return self::month($date) === self::MONTHS_PER_YEAR;
    }

    public static function isFirstMonthOfYear($date = null): bool
    {
        return self::month($date) === self::FIRST_MONTH;
    }

    public static function lastMonth($date = null): int
    {
        $month = self::month($date);
        return $month === self::January ? self::December : $month - 1;
    }

    public static function nextMonth($date = null): int
    {
        $month = self::month($date);
        return $month === self::December ? self::January : $month + 1;
    }

    public static function nextYear($date = null): int
    {
        return self::year($date) + 1;
    }

    public static function lastYear($date = null): int
    {
        return self::year($date) - 1;
    }

    public static function formatEquals($date1, $date2, string $format): bool
    {
        return self::immutable($date1)->format($format) === self::immutable($date2)->format($format);
    }

    public static function isSameDecade($date1, $date2 = null, $ofSameCentury = true): bool
    {
        $century1 = $ofSameCentury ? self::century($date1) : null;
        $century2 = $ofSameCentury ? self::century($date2) : null;
        return self::decade($date1) === self::decade($date2) && $century1 === $century2;
    }

    public static function isSameCentury($date1, $date2 = null): bool
    {
        return self::century($date1) === self::century($date2);
    }

    public static function isSameYear($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['year']);
    }

    public static function isSameMonth($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::formatEquals($date1, $date2, self::$formats['month']) && $year1 === $year2;
    }

    public static function isSameDay($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['day']);
    }

    public static function isSameHour($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['hour']);
    }

    public static function isSameMinute($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['minute']);
    }

    public static function isSameSecond($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['second']);
    }

    public static function isSameMicrosecond($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['microsecond']);
    }

    public static function isSameTime($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['time']);
    }

    public static function isSameDayOfWeek($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['dayOfWeek']);
    }

    public static function isSameDayOfYear($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::formatEquals($date1, $date2, self::$formats['month']) && $year1 === $year2;
    }

    public static function isSameWeekOfYear($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::formatEquals($date1, $date2, self::$formats['weekOfYear']) && $year1 === $year2;
    }

    public static function isSameDaysInMonth($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['daysInMonth']);
    }

    public static function isSameTimestamp($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['timestamp']);
    }

    public static function isSameBirthday($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::formatEquals($date1, $date2, self::$formats['birthday']) && $year1 === $year2;
    }

    public static function isSameDate($date1, $date2 = null): bool
    {
        return self::formatEquals($date1, $date2, self::$formats['date']);
    }

    public static function isSameQuarterOfYear($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::quarterOfYear($date1) === self::quarterOfYear($date2) && $year1 === $year2;
    }

    public static function isSameHalfOfYear($date1, $date2 = null, bool $ofSameYear = true): bool
    {
        $year1 = $ofSameYear ? self::year($date1) : null;
        $year2 = $ofSameYear ? self::year($date2): null;
        return self::halfOfYear($date1) === self::halfOfYear($date2) && $year1 === $year2;
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

    public static function isWorkday($date = null, array $holidays = [], array $weekend = null): bool
    {
        $dateTime = self::immutable($date);
        $dayOfWeek = self::dayOfWeek($dateTime);
        $weekend = $weekend === null ? self::$weekend : $weekend;

        if (in_array($dayOfWeek, $weekend)) {
            return false;
        }

        foreach ($holidays as $holiday) {
            if (self::isSameDate($dateTime, $holiday)) {
                return false;
            }
        }

        return true;
    }

    public static function nextWorkday($begin = null, array $holidays = [], array $weekend = null): DateTimeImmutable
    {
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
        $day = $day ?? self::day();

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

    public static function yearMonth(int $count, $beginDate = null, $format = 'Y-m'): array
    {
        $result = self::monthly($count, 1, $beginDate);
        return self::formatAll($result, $format);
    }

    public static function weeks(string $dictionary = null): array
    {
        $dictionary = is_string($dictionary) && class_exists($dictionary) ? new $dictionary() : $dictionary;
        return [
            self::Monday => $dictionary ? $dictionary->week(self::Monday) : 'Monday',
            self::Tuesday => $dictionary ? $dictionary->week(self::Tuesday) : 'Tuesday',
            self::Wednesday => $dictionary ? $dictionary->week(self::Wednesday) : 'Wednesday',
            self::Thursday => $dictionary ? $dictionary->week(self::Thursday) : 'Thursday',
            self::Friday => $dictionary ? $dictionary->week(self::Friday) : 'Friday',
            self::Saturday => $dictionary ? $dictionary->week(self::Saturday) : 'Saturday',
            self::Sunday => $dictionary ? $dictionary->week(self::Sunday) : 'Sunday'
        ];
    }

    public static function weekdays(string $dictionary = null): array
    {
        $weeks = self::weeks($dictionary);
        foreach (self::$weekend as $weekend) {
            unset($weeks[$weekend]);
        }

        return $weeks;
    }

    public static function weekend(string $dictionary = null): array
    {
        $weeks = self::weeks($dictionary);
        foreach ($weeks as $n => $name) {
            if (!in_array($n, self::$weekend)) {
                unset($weeks[$n]);
            }
        }

        return $weeks;
    }

    public static function localeWeeks(string $locale = null): array
    {
        $currentLocale = setlocale(LC_TIME, 0);
        if ($locale !== null) {
            setlocale(LC_TIME, $locale);
        }

        $result = [];
        foreach (self::weeks() as $key => $name) {
            $result[$key] = ucfirst(strftime('%A', strtotime("last $name")));
        }

        if ($locale !== null) {
            setlocale(LC_TIME, $currentLocale);
        }

        return $result;
    }

    public static function months(string $dictionary = null): array
    {
        $dictionary = is_string($dictionary) && class_exists($dictionary) ? new $dictionary() : $dictionary;
        return [
            self::January => $dictionary ? $dictionary->month(self::January) : 'January',
            self::February => $dictionary ? $dictionary->month(self::February) : 'February',
            self::March => $dictionary ? $dictionary->month(self::March) : 'March',
            self::April => $dictionary ? $dictionary->month(self::April) : 'April',
            self::May => $dictionary ? $dictionary->month(self::May) : 'May',
            self::June => $dictionary ? $dictionary->month(self::June) : 'June',
            self::July => $dictionary ? $dictionary->month(self::July) : 'July',
            self::August => $dictionary ? $dictionary->month(self::August) : 'August',
            self::September => $dictionary ? $dictionary->month(self::September) : 'September',
            self::October => $dictionary ? $dictionary->month(self::October) : 'October',
            self::November => $dictionary ? $dictionary->month(self::November) : 'November',
            self::December => $dictionary ? $dictionary->month(self::December) : 'December',
        ];
    }

    public static function localeMonths(string $locale = null): array
    {
        $currentLocale = setlocale(LC_TIME, 0);
        if ($locale !== null) {
            setlocale(LC_TIME, $locale);
        }

        $result = [];
        foreach (self::months() as $key => $name) {
            $result[$key] = ucfirst(strftime('%B', strtotime("01 $name")));
        }

        if ($locale !== null) {
            setlocale(LC_TIME, $currentLocale);
        }

        return $result;
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
            return $boundaries ? $value >= $i || $value <= $f : $value > $i || $value < $f ;
        }

        return $boundaries ? $value >= $i && $value <= $f : $value > $i && $value < $f ;
    }

    public static function monthBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        $month = self::month($date);
        return self::cyclicBetween($i, $f, $month, $boundaries);
    }

    public static function dayBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        return self::cyclicBetween($i, $f, self::day($date), $boundaries);
    }

    public static function dayOfWeekBetween(int $i, int $f, $date = null, bool $boundaries = true): bool
    {
        return self::cyclicBetween($i, $f, self::dayOfWeek($date), $boundaries);
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
