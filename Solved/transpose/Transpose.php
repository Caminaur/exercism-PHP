<?php

declare(strict_types=1);

function transpose(array $input): array
{
    // We filter the empty inputs.
    if (empty(array_filter($input,'trim'))) return [''];

    // Find longest possible line. 
    $height = 0;
    foreach ($input as $s) {
        if (strlen($s)>$height) {
            $height = strlen($s);
        }
    }

    // We create an array with the lenght neccesary and we fill it with empty strings
    $response = array_fill(0,$height,'');

    // for each line
    for ($w=0; $w < count($input) ; $w++) {
        $current = $input[$w]; // Fracture // 8         
        for ($c=0; $c < $height ; $c++) { 
            // If it doesn't exists we add " "
            $t = $current[$c] ?? " ";
            $response[$c] .= $t;
        }
    }

    // trim the last value of the array
    $response[count($response)-1] = rtrim(end($response));

    return $response;
}
