<?php

declare(strict_types=1);

function slices(string $digits, int $series): array
{
    $digits_length = strlen($digits);

    // Posible Exceptions...
    if ($series == 0) throw new Exception("Serie too short!");
    if ($digits_length < $series) throw new Exception("Digits too short");

    $calculated_array_lenth = $digits_length - $series;
    $response = [];

    for ($m=0; $m <= $calculated_array_lenth; $m++) { 
        $string = '';
        for ($q=0; $q < $series ; $q++) { 
            $string .= $digits[$q+$m];
        }
        $response[] = $string;
    }
    
    return $response;
}
