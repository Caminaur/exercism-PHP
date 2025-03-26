<?php


declare(strict_types=1);

function getClassification(int $number): string
{
    if ($number <= 0) throw new InvalidArgumentException('Number must be greater than 0',1);
    if ($number == 1) return 'deficient';

    $aliquot_sum = 0;
   
    // Aliquot sum
    for ($i=1; $i < $number ; $i++) { 
        if ($number % $i == 0) {
            $aliquot_sum += $i;
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
