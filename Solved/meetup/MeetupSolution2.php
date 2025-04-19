<?php

declare(strict_types=1);

function meetup_day(int $year, int $month, string $which, string $weekday): DateTimeImmutable
{
    switch ($which) {
        case 'first':
        case 'second':
        case 'third':
        case 'fourth':
        case 'last':
            return new DateTimeImmutable("$which $weekday of $year-$month");
        case 'teenth':
            for ($day = 13; $day <= 19; $day++) {
                $date = new DateTimeImmutable("$year-$month-$day");
                if ($date->format('l') === $weekday) {
                    return $date;
                }
            }
        default:
            throw new InvalidArgumentException("Invalid descriptor: $which");
    }
}

// https://www.php.net/manual/en/dateinterval.createfromdatestring.php
// https://www.php.net/manual/en/class.dateinterval.php
// https://www.php.net/manual/en/language.oop5.cloning.php