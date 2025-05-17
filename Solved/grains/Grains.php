<?php

declare(strict_types=1);

function square(int $number): string
{
    if ($number <= 0 || $number > 64) {
        throw new InvalidArgumentException("The number must be between 1 and 64");
    }
    return bcpow('2', (string)($number - 1));
}

function total(): string
{
    return bcsub(bcpow('2', '64'), '1');
}

// https://www.php.net/manual/en/function.bcpow.php
// https://www.php.net/manual/en/function.bcsub.php

// An arbitrary precision number is a number that can be represented with as many digits as needed,
// without being limited by the fixed size of standard data types like 32-bit or 64-bit integers.

// This allows for exact calculations with very large integers or high-precision decimals that would otherwise overflow or lose accuracy.

// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128
// 1 2 4 8 16 32 64 128