<?php

declare(strict_types=1);

/**
 * Devuelve un array con todos los números primos hasta un límite dado
 *
 * @param int $number El número máximo a evaluar
 * @return int[] Lista de números primos
 */
function sieve(int $number): array
{
    $arr_numbers = range(1, $number);
    $values_to_remove = [1];
    foreach ($arr_numbers as $n) {
        if (in_array($n, $values_to_remove)) continue;
        $multiplier = 2;
        while (($n * $multiplier) <= $number) {
            $values_to_remove[] = $n * $multiplier;
            $multiplier++;
        }
    }

    $prime_numbers = array_filter($arr_numbers, function ($number) use ($values_to_remove) {
        return !in_array($number, $values_to_remove);
    });
    return array_values($prime_numbers);
}
