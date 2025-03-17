<?php

declare(strict_types=1);

function nucleotideCount(string $input): array
{
    $nucleotides = ['a'=>0, 'c'=>0, 't'=>0, 'g'=>0];
    $letters = str_split($input);
    foreach ($letters as $l) {
        $l = strtolower($l);
        if (!array_key_exists($l,$nucleotides)) {
            throw new Exception("Thats not human...😱",1);
        }
        $nucleotides[$l]++;
    }
    return $nucleotides;
}
