<?php

declare(strict_types=1);

function findFewestCoins(array $coins, int $amount): array
{
    if ($amount === 0) return [];
    if ($amount < 0) throw new InvalidArgumentException('Cannot make change for negative value');
    if ($amount < $coins[0]) {
        throw new InvalidArgumentException('No coins small enough to make change');
    }
    // Initialize DP Array
    $shortestLength = PHP_INT_MAX;
    $dp = [];
    $dp[0] = [];
    // Walk possible paths
    for ($i = 0; $i <= $amount; ++$i) {
        if (!isset($dp[$i])) continue;
        foreach ($coins as $coin) {
            $newSum = $i + $coin;
            if ($newSum > $amount) continue;
            $newPath = [...$dp[$i], $coin];
            if (!isset($dp[$newSum]) || count($dp[$newSum]) > count($newPath)) {
                $dp[$newSum] = $newPath;
            }
        }
    }
    if (!isset($dp[$amount])) {
        throw new InvalidArgumentException('No combination can add up to target');
    }
    var_dump($dp);
    return $dp[$amount];
}

