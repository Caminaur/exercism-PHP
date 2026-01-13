<?php

declare(strict_types=1);

function smallest(int $min, int $max): array
{
    $result = [];
    $smallestPalindrome = PHP_INT_MAX;
    for ($i = $min; $i <= $max; $i++) {
        for ($q = $i; $q <= $max; $q++) {
            $number = $i * $q;
            if (isPalindrome($number)) {
                if ($number < $smallestPalindrome) {
                    $smallestPalindrome = $number;
                    $result = [];
                    $result[] = [$i, $q];
                } elseif ($number === $smallestPalindrome) {
                    $result[] = [$i, $q];
                }
            }
        }
    }
    if ($smallestPalindrome === PHP_INT_MAX) {
        throw new Exception("No Palindrome found in the range between $min and $max");
    }
    return [$smallestPalindrome, $result];
}

function largest(int $min, int $max): array
{
    $result = [];
    $biggestPalindrome = PHP_INT_MIN;
    for ($i = $min; $i <= $max; $i++) {
        for ($q = $i; $q <= $max; $q++) {
            $number = $i * $q;
            if (isPalindrome($number)) {
                if ($number > $biggestPalindrome) {
                    $biggestPalindrome = $number;
                    $result = [];
                    $result[] = [$i, $q];
                } elseif ($number === $biggestPalindrome) {
                    $result[] = [$i, $q];
                }
            }
        }
    }
    if ($biggestPalindrome === PHP_INT_MIN) {
        throw new Exception("No Palindrome found in the range between $min and $max");
    }
    return [$biggestPalindrome, $result];
}

function isPalindrome(int $num): bool
{
    $reverse_num = (int)strrev((string)$num);
    return $num === $reverse_num;
}
