<?php

declare(strict_types=1);

function crypto_square(string $plaintext): string
{

    $normalize_text = preg_replace('/[^a-z0-9]/', '', strtolower($plaintext));
    $string_length = strlen($normalize_text);

    if ($string_length == 0) return '';


    // with floor and ceil we make sure that $r - $c <= 1
    $r = intval(floor(sqrt($string_length)));
    $c = intval(ceil(sqrt($string_length)));

    if ($r * $c < $string_length) {
        $r++;
    }

    $array = str_split($normalize_text, $c);

  
    // fill the not full row with spaces
    foreach ($array as $key => $value) {
        $array[$key] = str_pad($value, $c, ' ', STR_PAD_RIGHT);
    }
    
    
    $cypher_text = '';


    // recorremos las columnas
    for ($i=0; $i < $c ; $i++) { 
        // recorremos las filas
        for ($j=0; $j < $r; $j++) { 
            $cypher_text .= $array[$j][$i];
        }
    }

    $normalize_cypher = chunk_split($cypher_text, $r, ' ');
    if (strlen($normalize_cypher) > $string_length) {
        $normalize_cypher = substr($normalize_cypher, 0, -1);
    }

    return $normalize_cypher;
}
