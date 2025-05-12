<?php

declare(strict_types=1);

const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';


function modInverse(int $numero, int $modulo = 26): int
{
    $moduloOriginal = $modulo;
    $coeficienteAnterior = 0;
    $coeficienteActual = 1;

    while ($numero > 1) {
        $cociente = intdiv($numero, $modulo);
        $restoAnterior = $modulo;

        $modulo = $numero % $modulo;
        $numero = $restoAnterior;

        $temporal = $coeficienteAnterior;
        $coeficienteAnterior = $coeficienteActual - $cociente * $coeficienteAnterior;
        $coeficienteActual = $temporal;
    }

    if ($coeficienteActual < 0) {
        $coeficienteActual += $moduloOriginal;
    }

    return $coeficienteActual;
}



function getDivisors($number)
{
    $divisors = [];

    for ($i = 1; $i <= $number; $i++) {
        if ($number % $i === 0) {
            $divisors[] = $i;
        }
    }
    return $divisors;
}

function areCoprimes($a, $b)
{
    $aDivisors = getDivisors($a);
    $bDivisors = getDivisors($b);
    return count(array_intersect($aDivisors, $bDivisors)) === 1;
}

function encode(string $text, int $a, int $b): string
{
    $text = preg_replace('/[^a-z0-9]/', '', strtolower($text));
    $m = 26;
    // are A y M coprimes?
    $areCoprimes = areCoprimes($a, $m);
    if (!$areCoprimes) {
        throw new Exception("$a and $m are not coprimes!");
    }

    $cypherText = '';
    for ($q = 0; $q < strlen($text); $q++) {
        $index = strpos(ALPHABET, $text[$q]);
        if ($index === false) {
            $cypherText .= $text[$q];
            continue;
        }
        $e = (($a * $index) + $b) % $m;
        $cypherText .= ALPHABET[$e];
    }

    $cypherText = str_split($cypherText, 5);

    return implode(' ', $cypherText);
}

function decode(string $text, int $a, int $b): string
{
    $text = preg_replace('/[^a-z0-9]/', '', strtolower($text));
    $m = 26;
    $areCoprimes = areCoprimes($a, $m);
    if (!$areCoprimes) {
        throw new Exception("$a and $m are not coprimes!");
    }

    $clearText = '';
    for ($q = 0; $q < strlen($text); $q++) {
        $y = strpos(ALPHABET, $text[$q]); // 22
        if ($y === false) {
            $clearText .= $text[$q];
            continue;
        }
        $c = (modInverse($a, $m) * ($y - $b)) % $m;
        $clearText .= ALPHABET[$c];
    }

    return $clearText;
}

// I = index of letter
// m = length of alphabet
// A & B = Integers of the encryption key
// A & M must be coprime
    // Ex. 
        // 8 → 4 2 1    
        // 9 → 3 1
// The can only share 1 as a common divider
// If they are not coprime throw error

// Digits and valid but not encripted
// Spaces and punctuation characters are excluded.

// We remove spaces and punctuation, cypher everything but the numbers and then separate it in groups of 5 letters.

// D(y) = (a^-1)(y - b) % 26
// modular multiplicative inverse
