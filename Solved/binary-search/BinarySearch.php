<?php

declare(strict_types=1);


function find(int $needle, array $haystack, int $left = 0, $right = null): int
{
    if ($right === null) {
        $right = count($haystack) - 1;
    }
    if ($left > $right) {
        return -1;
    }
    $mid = (int)floor(($left + $right) / 2);
    if ($haystack[$mid] === $needle) {
        return $mid;
    }
    if ($haystack[$mid] < $needle) {
        return find($needle, $haystack, $mid + 1, $right);
    } else {
        return find($needle, $haystack, $left, $mid - 1);
    }
}
