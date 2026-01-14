<?php

declare(strict_types=1);

function smallest(int $min, int $max): array
{
    if ($min > $max) {
        throw new Exception("Invalid range");
    }
    $smallestPalindrome = PHP_INT_MAX;
    $factors = [];
    for ($i = $min; $i <= $max; $i++) {
        for ($q = $i; $q <= $max; $q++) {

            if ($i * $i > $smallestPalindrome) {
                break 2;
            }
            $product = $i * $q;
            if ($product > $smallestPalindrome) {
                break;
            }

            if (isPalindrome($product)) {

                $possibleFactors = $i >= $q ? [$q, $i] : [$i, $q];

                if ($product < $smallestPalindrome) {
                    $smallestPalindrome = $product;
                    $factors = [$possibleFactors];
                } elseif ($product === $smallestPalindrome) {
                    $factors[] = $possibleFactors;
                }
            }
        }
    }

    if ($smallestPalindrome === PHP_INT_MAX) {
        throw new Exception("No Palindrome found in the range between $min and $max");
    }

    return [$smallestPalindrome, $factors];
}

function largest(int $min, int $max): array
{
    if ($min > $max) {
        throw new Exception("Invalid range");
    }

    $largestPalindrome = PHP_INT_MIN;
    $factors = [];

    for ($i = $max; $i >= $min; $i--) {
        for ($q = $i; $q >= $min; $q--) {
            if ($i * $i < $largestPalindrome) {
                break 2;
            }

            $product = $i * $q;
            if ($product < $largestPalindrome) {
                break;
            }
            if (isPalindrome($product)) {
                $possibleFactors = $i >= $q ? [$q, $i] : [$i, $q];
                if ($product > $largestPalindrome) {
                    $largestPalindrome = $product;
                    $factors = [$possibleFactors];
                } elseif ($product === $largestPalindrome) {
                    $factors[] = $possibleFactors;
                }
            }
        }
    }

    if ($largestPalindrome === PHP_INT_MIN) {
        throw new Exception("No Palindrome found in the range between $min and $max");
    }

    return [$largestPalindrome, $factors];
}

function isPalindrome(int $num): bool
{
    return $num === (int)strrev((string)$num);
}
