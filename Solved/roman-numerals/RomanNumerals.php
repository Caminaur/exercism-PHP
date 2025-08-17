<?php

declare(strict_types=1);



function resolverMiles($n)
{
    return str_repeat("M", (int)$n);
}
function resolverCientos($n)
{
    if ($n <= 3) {
        return str_repeat("C", (int)$n);
    }
    if ($n === 5) {
        return "D";
    }
    if ($n === 4) {
        $response = '';
        return "CD";
    }
    if ($n > 5 && $n < 9) {
        $response = 'D' . str_repeat("C", $n - 5);
        return $response;
    }

    // 900
    return "CM";
}
function resolverDecenas($n)
{
    if ($n <= 3) {
        return str_repeat("X", (int)$n);
    }
    if ($n === 5) {
        return "L";
    }
    if ($n === 4) {
        $response = '';
        return "XL";
    }
    if ($n > 5 && $n < 9) {
        $response = 'L' . str_repeat("X", $n - 5);
        return $response;
    }

    // 90
    return "XC";
}

function resolverUnDigito($n)
{
    if ($n <= 3) {
        return str_repeat("I", (int)$n);
    }
    if ($n === 5) {
        return "V";
    }
    if ($n === 4) {
        $response = '';
        return "IV";
    }
    if ($n > 5 && $n < 9) {
        $response = 'V' . str_repeat("I", $n - 5);
        return $response;
    }

    // 9
    return "IX";
}

function toRoman(int $number): string
{
    $string = (string) $number;
    $split = str_split($string);
    $response = '';

    $firstDigit = count($split);
    for ($i = 1; $i <= count($split); $i++) {
        $n = (int)$split[$i - 1];
        if ($firstDigit === 4) {
            $response .= resolverMiles($n);
            $firstDigit--;
            continue;
        }
        if ($firstDigit === 3) {
            $response .= resolverCientos($n);
            $firstDigit--;
            continue;
        }
        if ($firstDigit === 2) {
            $response .= resolverDecenas($n);
            $firstDigit--;
            continue;
        }
        if ($firstDigit === 1) {
            $response .= resolverUnDigito($n);
            $firstDigit--;
            continue;
        }
    }

    return $response;
}

// 1024
