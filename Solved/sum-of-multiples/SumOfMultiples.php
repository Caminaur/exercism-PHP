<?php

declare(strict_types=1);

function sumOfMultiples(int $level, array $multiples): int
{
    $uniqueMultiples = [];

    foreach ($multiples as $val) {
        $number = $val;

        if ($val === 0) {
            continue;
        }

        while ($number < $level) {
            $uniqueMultiples[$number] = true;
            $number += $val;
        }
    }

    return array_sum(array_keys($uniqueMultiples));
}
