<?php

declare(strict_types=1);

class ProteinTranslation
{
    private array $codon_map = [
        'AUG' => 'Methionine',
        'UUU' => 'Phenylalanine',
        'UUC' => 'Phenylalanine',
        'UUA' => 'Leucine',
        'UUG' => 'Leucine',
        'UCU' => 'Serine',
        'UCC' => 'Serine',
        'UCA' => 'Serine',
        'UCG' => 'Serine',
        'UAU' => 'Tyrosine',
        'UAC' => 'Tyrosine',
        'UGU' => 'Cysteine',
        'UGC' => 'Cysteine',
        'UGG' => 'Tryptophan',
        'UAA' => 'STOP',
        'UAG' => 'STOP',
        'UGA' => 'STOP',
    ];

    public function getProteins(string $string): array
    {
        $codons = str_split($string, 3);
        $response = [];
        foreach ($codons as $codon) {
            $protein = $this->codon_map[$codon] ?? NULL;
            if ($protein === NULL) throw new InvalidArgumentException('Invalid codon');
            if ($protein === "STOP") return $response;
            $response[] = $protein;
        }
        return $response;
    }
}

# split string in groups of 3
# loop the array of the groups and add the valid proteins corresponding to the codon
    # if a stop codon is found return the result
    # if a invalid codon is given throw exception