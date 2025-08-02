<?php

declare(strict_types=1);

function prime(int $n): int|bool
{
    if ($n === 0) {
        return false;
    }

    $count = 0;
    $num = 1;

    while ($count < $n) {
        $num++;
        if (isPrime($num)) {
            $count++;
        }
    }

    return $num;
}

function isPrime(int $number): bool
{
    if ($number < 2) return false;
    if ($number === 2) return true;
    if ($number % 2 === 0) return false;

    // ahora solo revisamos impares
    for ($i = 3; $i <= sqrt($number); $i += 2) {
        if ($number % $i === 0) {
            return false;
        }
    }
    return true;
}
