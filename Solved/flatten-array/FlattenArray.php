<?php

declare(strict_types=1);

function flatten(array $input): array
{
    $response = [];
    foreach ($input as $item) {
        if ($item === null) continue;

        if (is_array($item)) {
            $response = array_merge($response, flatten($item));
        } else {
            $response[] = $item;
        }
    }

    return $response;
}
