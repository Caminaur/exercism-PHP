<?php

declare(strict_types=1);


function ciclar_array($array): array
{
    $response = [];

    foreach ($array as $v) {
        if ($v === null) continue;
        if (is_array($v)) {
            $response = array_merge($response, ciclar_array($v));
            continue;
        }
        $response[] = $v;
    }

    return $response;
}

function flatten(array $input): array
{
    $response = [];
    foreach ($input as $item) {
        if ($item === null) continue;

        if (is_array($item)) {
            $response = array_merge($response, ciclar_array($item));
            continue;
        }
        $response[] = $item;
    }

    return $response;
}

# Crear el Response Array
# Tomar la lista y ciclarla
# Si el objeto es un array, iterar cada objeto del mismo y agregarlo al Response array
# Tener cuidado con que tan nested esta el array