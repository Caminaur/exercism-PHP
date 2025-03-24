<?php

declare(strict_types=1);

// $this->assertEquals(
//     [
//         "   A   ",0
//         "  B B  ",1
//         " C   C ",2
//         "D     D",3 n + n+1 
//         " C   C ",
//         "  B B  ",
//         "   A   ",
//     ],

// [
//     "  A  ",
//     " B B ",
//     "C   C", n + n+1 5 
//     " B B ",
//     "  A  ",
// ],
function diamond(string $letter): array
{
    // create dictionary
    $alphabet = [];
    foreach(range('A','Z') as $l){
        $alphabet[] = $l;
    }

    // letter C
    $key = array_search($letter,$alphabet); // 3
    $length = 2*$key + 1; // 7

    $response = [];
    $input='';
    for ($i=0; $i <= $key ; $i++) {
        $middlePAD = (($i*2)-1) < 0 ? 0 : ($i*2)-1 ; 
        if($i==0){
            $input .= $alphabet[$i];
            $input = str_pad($input, $length, " ", STR_PAD_BOTH);
        } else{
            $input_centro= $alphabet[$i] . str_repeat(" ",$middlePAD) . $alphabet[$i];
            $input = str_pad($input_centro, $length, ' ', STR_PAD_BOTH); 
        }
        $response[] = $input;
    }
    for ($i=$key-1; $i >= 0 ; $i--) {
        $middlePAD = (($i*2)-1) < 0 ? 0 : ($i*2)-1 ; 

        if($i==0){
            $input = $alphabet[$i];
        } else{
            $input = $alphabet[$i] . str_repeat(" ",$middlePAD) . $alphabet[$i];
        }
        $input = str_pad($input, $length, " ", STR_PAD_BOTH);
        $response[] = $input;
    }

    return $response;
}
