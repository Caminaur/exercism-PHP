<?php

declare(strict_types=1);

function say(int $number): string
{
    if ($number === 0) {
        return "zero";
    }
    verifyEdgeCases($number);

    $resp = '';
    $numberGroup = formatNumberArray((string)$number);

    foreach ($numberGroup as $key => $n) {
        if ($n === 0) continue;
        if ($n >= 100) {
            $resp .= solveHundred($n) . ' ' . quantityGroup($key) . ' ';
        } else {
            $resp .= solveLastTwoDigits($n) . ' ' . quantityGroup($key) . ' ';
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
    $hundreds = intdiv($n, 100);
    $lastTwo = $n % 100;
    $resp = '';
    $resp .= solveLastTwoDigits($hundreds) . ' hundred';
    $resp .= ' ' . solveLastTwoDigits($lastTwo);
    return $resp;
}

function formatNumberArray(string $number): array
{
    $resp = [];
    $numberArray = str_split(strrev($number), 3);
    foreach ($numberArray as $value) {
        $resp[] = (int)strrev($value);
    }
    return array_reverse($resp, true);
}

function solveLastTwoDigits(int $n): string
{
    $result = "";
    if ($n < 21) return first20($n);

    $firstDigit = intdiv($n, 10);
    $secondDigit = $n % 10;
    if ($secondDigit == 0) {
        return decenas($firstDigit);
    }
    return decenas($firstDigit) . '-' . first20($secondDigit);
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
        default => "",
    };
}
