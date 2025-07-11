<?php

declare(strict_types=1);

function factors(int $number): array
{
    $primeFactors = [];
    $a = 2;
    while ($number > 1) {
        if ($number % $a === 0) {
            $number = $number / $a;
            $primeFactors[] = $a;
            $a = 2;
        } else {
            $a++;
        }
    }
    return $primeFactors;
}
