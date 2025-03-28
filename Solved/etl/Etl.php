<?php

declare(strict_types=1);

function transform(array $oldValues): array
{
    $newValues = [];

    // Solution 1
    // foreach ($oldValues as $key => $array) {
    //     foreach ($array as $letter) {
    //         $newValues[strtolower($letter)] = $key;
    //     }
    // }

    // Solucion 2 
    array_walk($oldValues, function($array,$key) use(&$newValues) {
        array_walk($array, function($letter) use($key,&$newValues){
            $newValues[strtolower($letter)] = $key;
        });
    });

    return $newValues;
}
