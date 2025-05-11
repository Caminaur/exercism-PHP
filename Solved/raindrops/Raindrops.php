<?php

declare(strict_types=1);

function raindrops(int $number): string
{
    $response = "";

    $map = [
        3 => "Pling",
        5 => "Plang",
        7 => "Plong"
    ];

    foreach ($map as $key => $sound) {
        if ($number % $key === 0) {
            $response .= $sound;
        }
    }

    return empty($response) ? (string) $number : $response;
}
