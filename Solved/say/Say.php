<?php

declare(strict_types=1);

function say(int $number): string
{
    if ($number == 0) {
        return "zero";
    }
    verifyEdgeCases($number);

    $resp = '';
    $numberGroup = formatNumberArray((string)$number);

    foreach ($numberGroup as $key => $n) {
        $length = strlen((string)$n);
        if ($length == 3) {
            $resp .= solveHundred($n) . ' ' . quantityGroup($key) . ' ';
        } else {
            if ($n !== 0) {
                $resp .= solveLastTwoDigits($n) . ' ' . quantityGroup($key) . ' ';
            }
        }
    }
    return trim($resp);
}

function quantityGroup(int $n): string
{
    return match ($n) {
        0 => '',
        1 => 'thousand',
        2 => 'million',
        3 => 'billion',
        4 => 'trillion',
    };
}

function verifyEdgeCases(int $number): void
{

    if ($number < 0) {
        throw new InvalidArgumentException("Input out of range");
    }
    if ($number > 999999999999) {
        throw new InvalidArgumentException("Input out of range");
    }
}
function solveHundred(int $n): string
{
    $resp = '';
    $groups = array_map(NULL, str_split((string)$n));
    $first = $groups[0];
    $lastTwo = intval($groups[1] . $groups[2]);
    $resp .= solveLastTwoDigits((int)$first) . ' hundred';
    $resp .= ' ' . solveLastTwoDigits($lastTwo);
    return $resp;
}

function formatNumberArray(string $number): array
{
    $resp = [];
    $numberArray = str_split(strrev($number), 3);
    foreach ($numberArray as $key => $value) {
        $resp[] = (int)strrev($value);
    }
    return array_reverse($resp, true);
}

function solveLastTwoDigits(int $n): string
{
    $result = "";
    if ($n < 21) {
        return first20($n);
    } else {
        $firstDigit = (int)((string)$n)[0];
        $secondDigit = (int)((string)$n)[1];
        if ($secondDigit == 0) {
            $result .= decenas($firstDigit);
        } else {
            $result .= decenas($firstDigit) . '-' . first20($secondDigit);
        }
    }
    return $result;
}
function first20(int $n): string
{
    return match ($n) {
        1  => "one",
        2  => "two",
        3  => "three",
        4  => "four",
        5  => "five",
        6  => "six",
        7  => "seven",
        8  => "eight",
        9  => "nine",
        10 => "ten",
        11 => "eleven",
        12 => "twelve",
        13 => "thirteen",
        14 => "fourteen",
        15 => "fifteen",
        16 => "sixteen",
        17 => "seventeen",
        18 => "eighteen",
        19 => "nineteen",
        20 => "twenty",
        default => ""
    };
}
function decenas(int $n): string
{
    return match ($n) {
        2 => "twenty",
        3 => "thirty",
        4 => "forty",
        5 => "fifty",
        6 => "sixty",
        7 => "seventy",
        8 => "eighty",
        9 => "ninety",
    };
}
