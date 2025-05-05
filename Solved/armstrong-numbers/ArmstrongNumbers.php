<?php

declare(strict_types=1);

/**
 * Verifies if a number is an Armstrong number
 * @param int $number The number to check.
 * @return bool True if it's an Armstrong number, false otherwise.
 */
function isArmstrongNumber(int $number): bool
{
    $length = strlen((string)$number);
    $digits = str_split((string)$number);
    $sum = 0;
    foreach ($digits as $d) {
        $sum += pow((int)$d, $length);
    }
    return $number === $sum;
}
