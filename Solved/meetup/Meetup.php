<?php

declare(strict_types=1);

const ID_TO_DAY = [0 => "Sunday", 1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday", 6 => "Saturday"];


function meetup_day(int $year, int $month, string $which, string $weekday): DateTimeImmutable
{
    // We step on the first day of the month
    $date_start = new DateTime("{$year}-{$month}-1");
    $month_length = (int) $date_start->format('t');
    $starting_day = $date_start->format("l");

    $month_days = [];
    $control_id = array_filter(ID_TO_DAY, fn($d) => $d === $starting_day, ARRAY_FILTER_USE_BOTH);
    $control_id = array_keys($control_id)[0]; // ID of the day

    for ($i = 0; $i < $month_length; $i++) {
        $month_days[$i] = ID_TO_DAY[$control_id];
        $control_id = ($control_id + 1) % 7;
    }

    $which_dict = [
        'first' => 1,
        'second' => 2,
        'third' => 3,
        'fourth' => 4,
        'last' => 'last',
        'teenth' => 'teenth'
    ];

    $actual_date = '';
    $day_number = $which_dict[$which];
    switch ($which) {
        case 'first':
        case 'second':
        case 'third':
        case 'fourth':
            $appeared = 0;
            for ($i = 0; $i <= count($month_days); $i++) {
                if ($month_days[$i] === $weekday) {
                    $appeared++;
                    if ($appeared === $day_number) {
                        $actual_date = $i + 1;
                        break;
                    }
                }
            }
            return new DateTimeImmutable("{$year}-{$month}-{$actual_date}");
        case 'last':
            for ($i = 0; $i < count($month_days); $i++) {
                if ($month_days[$i] === $weekday) {
                    $actual_date = $i + 1;
                }
            }
            return new DateTimeImmutable("{$year}-{$month}-{$actual_date}");
        case 'teenth':
            for ($i = 12; $i < 19; $i++) {
                if ($month_days[$i] === $weekday) {
                    $actual_date = $i + 1;
                }
            }
            return new DateTimeImmutable("{$year}-{$month}-{$actual_date}");
        default:
            throw new InvalidArgumentException("Invalid descriptor: $which");
    }
}

// https://www.php.net/manual/en/dateinterval.createfromdatestring.php
// https://www.php.net/manual/en/class.dateinterval.php
// https://www.php.net/manual/en/language.oop5.cloning.php