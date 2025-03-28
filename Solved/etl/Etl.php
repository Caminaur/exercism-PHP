<?php

declare(strict_types=1);

function transform(array $oldValues): array
{
    $newValues = [];

    foreach ($oldValues as $key => $array) {
        foreach ($array as $letter) {
            $newValues[strtolower($letter)] = $key;
        }
    }

   
    return $newValues;
}
