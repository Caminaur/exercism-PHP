<?php


declare(strict_types=1);

function format(string $name, int $number): string
{
    $lastDigit = $number % 10;
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        $ordinal = $number . 'th';
    } else {
        $ordinal = match ($lastDigit) {
            1 => $number . 'st',
            2 => $number . 'nd',
            3 => $number . 'rd',
            default => $number . 'th'
        };
    }
    return $name . ', you are the ' . $ordinal . ' customer we serve today. Thank you!';
}
