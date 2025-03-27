<?php


declare(strict_types=1);

function getClassification(int $number): string
{
    if ($number <= 0) throw new InvalidArgumentException('Number must be greater than 0',1);
    if ($number == 1) return 'deficient';

    $aliquot_sum = 0;
   
    $sqrt = floor(sqrt($number)); // sacamos la raiz cuadrada del numbero y redondeamos hacia abajo
    
    for ($i=1; $i <= $sqrt; $i++) { 
        if ($number % $i == 0) {

            $pair = $number / $i;
            $aliquot_sum += $i;

            // ej number = 36
            //    i = 6
            //    pair = 6
            if ($pair != $i && $pair != $number) {
                $aliquot_sum += $pair;
            }
        }
    }
    
    switch ($aliquot_sum) {
        case $number:
            return 'perfect';
            break;
        case $aliquot_sum > $number:
            return 'abundant';
            break;
        case $aliquot_sum < $number:
            return 'deficient';
            break;
        default:
            return 'Error';
            break;
    }
    
}
