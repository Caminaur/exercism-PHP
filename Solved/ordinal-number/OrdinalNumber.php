<?php

declare(strict_types=1);

function toOrdinal(int $number): string
{
    $number = (string)$number;
    $lastDigit = $number[-1];

    if ($number === '0') return '0';
    if ($number > 10 && $number < 20) return $number . "th";
    return match (true) {
        $lastDigit === '1' => $number . 'st',
        $lastDigit === '2' => $number . 'nd',
        $lastDigit === '3' => $number . 'rd',
        default => $number . 'th',
    };
}
