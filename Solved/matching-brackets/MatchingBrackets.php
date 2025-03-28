<?php

declare(strict_types=1);

function brackets_match(string $input): bool
{
    // remove everything exept brackets parenthesis and braces
    $input = preg_replace('/[^(){}\[\]]/','',$input);
    $array = str_split($input); // [ '(','(','(',')',')',')' ];

    $dict = [
         ")"=>"(",
         "}"=>"{",
         "]"=>"[",
    ];

    $depth = 0; // we can make it like so
    $control = [
        // $depth => $bracket
    ];
    // every extra opening bracket ads depth and this depth needs to be resolved before matching the first nodes
    // [ 0
        // [ 1
            // [ 2
                // ( 3
                    // [ 4 
                    // ] 4 
                // ) 3 
            // ] 2
        // ] 1
    // ] 0

    for ($i=0; $i < count($array) ; $i++) { 
        
        $currentBracket = $array[$i]; // )

        // Si es un bracket que cierra
        if (isset($dict[$currentBracket])) {
            $sibling = $dict[$currentBracket]; // (
                
            // verificamos si su hermano esta en el nivel actual
            $doesControlExist =  isset($control[$depth]);
            $isSiblingOnSameLevel = $doesControlExist && $control[$depth] == $sibling;
            
            if ($isSiblingOnSameLevel) {
                unset($control[$depth]);
                $depth--;
            } else {
                // En caso de que no sea el par de cierre retornamos Falso
                return false;
            }
        } else{
            $depth++;
            $control[$depth] = $currentBracket;
        }
    }

    return empty($control);
}
