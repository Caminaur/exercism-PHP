<?php

declare(strict_types=1);



function findFewestCoins(array $coins, int $amount): array
{
    if($amount==0)return[];
    if($amount<0) throw new InvalidArgumentException('Cannot make change for negative value',1);
    if(min($coins)>$amount) throw new InvalidArgumentException('No coins small enough to make change',1);

    $array = array_fill(0, $amount + 1, PHP_INT_MAX);
    $array[0] = 0;

    $used_coins = array_fill(0, $amount + 1, null);

    foreach ($coins as $coin) { // 1 2 3 5
        for ($i = $coin; $i <= $amount; $i++) { // 1 2 3 4 5 6 7 
                                                // 2 3 4 5 6 7                                                
                                                // 3 4 5 6 7                                                
                                                // 5 6 7 
            $minimunCoinsNeeded = $array[$i - $coin] + 1;
            if ($minimunCoinsNeeded < $array[$i]) {
                $array[$i] = $minimunCoinsNeeded;
                $used_coins[$i] = $coin;
            }
        }
    }
    if ($used_coins[$amount]==NULL) throw new InvalidArgumentException('No combination can add up to target',1);
    
    $result_coins = [];

    while ($amount > 0) { // 27
        $coin = $used_coins[$amount]; 
        $result_coins[] = $coin;
        $amount -= $coin; 
    }
    if ($amount<0) {
        throw new InvalidArgumentException('No coins small enough to make change',1);
    }

    return array_reverse($result_coins);
}
