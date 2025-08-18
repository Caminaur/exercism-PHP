<?php

declare(strict_types=1);


function resolve(int $n, ?string $symbol1, ?string $v2, ?string $v3): string
{
    if ($n <= 3) {
        return str_repeat($symbol1, (int)$n);
    }
    if ($n === 5) {
        return $v2;
    }
    if ($n === 4) {
        return $symbol1 . $v2;
    }
    if ($n > 5 && $n < 9) {
        $response = $v2 . str_repeat($symbol1, $n - 5);
        return $response;
    }

    return $symbol1 . $v3;
}

function toRoman(int $number): string
{
    $string = (string) $number;
    $split = str_split($string);
    $response = '';

    $firstDigit = count($split);
    for ($i = 1; $i <= count($split); $i++) {
        $n = (int)$split[$i - 1];
        switch ($firstDigit) {
            case 4:
                $response .= str_repeat("M", (int)$n);
                $firstDigit--;
                break;
            case 3:
                $response .= resolve($n, "C", "D", "M");
                $firstDigit--;
                break;
            case 2:
                $response .= resolve($n, "X", "L", "C");
                $firstDigit--;
                break;
            default:
                $response .= resolve($n, "I", "V", "X");
                $firstDigit--;
                break;
        }
    }

    return $response;
}
