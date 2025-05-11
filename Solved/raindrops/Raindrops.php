<?php

declare(strict_types=1);

function raindrops(int $number): string
{
    $response = "";

    if ($number % 3 === 0) {
        $response .= "Pling";
    }
    if ($number % 5 === 0) {
        $response .= "Plang";
    }
    if ($number % 7 === 0) {
        $response .= "Plong";
    }
    if (empty($response)) return (string) $number;

    return $response;
}
