<?php

declare(strict_types=1);

function vlq_encode(array $input): array
{
    $response = [];

    $split_from_right_to_left = function($string){
        $chunks = [];
        while ($string !== '') {
            // 1000 0000
            $chunk = substr($string, -7); // 000 0000
            $string = substr($string, 0, -7); // 1
            $chunk = str_pad($chunk, 7, '0', STR_PAD_LEFT); // si hace falta agregamos
            $chunks[] = $chunk;
        }
    
        return array_reverse($chunks);
    };
    
    foreach ($input as $n) {
        
        $binary = decbin($n);

        // split in 7 from right to left
        $binaries = $split_from_right_to_left($binary);

        $binaries_with_MSB = [];
        for ($b=0; $b < count($binaries) ; $b++) { 
            if($b < count($binaries) - 1){
                $binaries_with_MSB[]= bindec('1'.$binaries[$b]);
            } else{
                $binaries_with_MSB[]= bindec('0'.$binaries[$b]);
            }
        }
        $response = array_merge($response, $binaries_with_MSB);
    }
    return $response;
}

function vlq_decode(array $input): array {
    $result = [];
    $current = '';

    foreach ($input as $byte) {
        $binary = str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);

        $msb = $binary[0]; // indica si hay mas
        $data = substr($binary, 1); // La data sin el msb

        $current .= $data;

        // si el msb es 0 llegamos al final del numero
        if ($msb === '0') {
            if (strlen($current) > 32 || bindec($current) > 0xFFFFFFFF) {
                throw new OverflowException("Value exceeds 32-bit unsigned integer");
            }
            $result[] = bindec($current);
            $current = ''; // Reiniciamos
        }

    }
    // Secuencia está incompleta
    if ($current !== '') {
        throw new InvalidArgumentException("Incomplete VLQ sequence");
    }

    return $result;
}