<?php

// Solucion sin bc library

declare(strict_types=1);

function square(int $n): string
{
    if ($n <= 0 || $n > 64) {
        throw new InvalidArgumentException("Debe estar entre 1 y 64");
    }

    return powerOfTwo($n - 1);
}

function total(): string
{
    return subtractStrings(powerOfTwo(64), '1');
}

function powerOfTwo(int $exp): string
{
    $result = '1';

    for ($i = 0; $i < $exp; $i++) {
        $result = multiplyByTwo($result);
    }

    return $result;
}

function multiplyByTwo(string $num): string
{
    $carry = 0;
    $res = '';

    for ($i = strlen($num) - 1; $i >= 0; $i--) {
        $digit = (int)$num[$i] * 2 + $carry;
        $res = ($digit % 10) . $res;
        $carry = intdiv($digit, 10);
    }

    if ($carry > 0) {
        $res = $carry . $res;
    }

    return $res;
}

function subtractStrings(string $mayor, string $menor): string
{
    $longitud = max(strlen($mayor), strlen($menor));
    $mayor = str_pad($mayor, $longitud, '0', STR_PAD_LEFT);
    $menor = str_pad($menor, $longitud, '0', STR_PAD_LEFT);

    $resultado = '';
    $prestamo = 0;

    for ($i = $longitud - 1; $i >= 0; $i--) {
        $digMayor = (int)$mayor[$i];
        $digMenor = (int)$menor[$i];

        $digito = $digMayor - $digMenor - $prestamo;

        if ($digito < 0) {
            $digito += 10;
            $prestamo = 1;
        } else {
            $prestamo = 0;
        }

        $resultado = $digito . $resultado;
    }

    return ltrim($resultado, '0') ?: '0';
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