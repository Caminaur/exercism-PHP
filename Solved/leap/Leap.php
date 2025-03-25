<?php

declare(strict_types=1);

function isLeap(int $year): bool
{

    $isDivisibleBy4 = $year % 4 == 0;
    $isDivisibleBy100 = $year % 100 == 0;
    $isDivisibleBy400 = $year % 400 == 0;

    if ($isDivisibleBy4 && !$isDivisibleBy100) {
        return true;
    } else{
        return $isDivisibleBy400;
    }
}
