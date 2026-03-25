<?php

declare(strict_types=1);

class Alphametics
{
    public function solve(string $puzzle): ?array
    {
        $uniqueLetterList = $this->getUniqueLetters($puzzle);
        $letters = array_keys($uniqueLetterList);
        [$productos, $resultado] = $this->getProductsAndResult($puzzle);
        $leadingLetters = $this->getLeadingLetters($productos, $resultado);
        $solution = $this->findSolution($letters, $productos, $resultado, $leadingLetters);
        return $solution;
    }

    private function wordToNumber(string $word, array $map): int
    {
        $numStr = '';
        $letters = str_split($word);

        foreach ($letters as $ch) {
            $numStr .= $map[$ch];
        }

        return intval($numStr);
    }

    private function findSolution(array $letters, array $productos, string $resultado, array $leadingLetters): ?array
    {
        $assignments = [];
        $usedDigits  = [];

        $found = $this->backtrack(
            0,
            $letters,
            $productos,
            $resultado,
            $assignments,
            $usedDigits,
            $leadingLetters
        );

        if ($found) {
            return $assignments; // mapa letra => dígito
        }

        return null;
    }

    private function getLeadingLetters(array $productos, string $resultado): array
    {
        $leading = [];
        foreach ($productos as $w) {
            $leading[$w[0]] = true;
        }
        $leading[$resultado[0]] = true;
        return $leading;
    }


    private function backtrack(
        int   $idx,
        array $letters,
        array $productos,
        string $resultado,
        array &$candidates,
        array &$usedDigits,
        array $leadingLetters
    ): bool {
        $n = count($letters);

        // If we assigned all candidates
        if ($idx === $n) {
            // we turn them into numbers and we verify if they are valid
            $sum = 0;
            foreach ($productos as $p) {
                $sum += $this->wordToNumber($p, $candidates);
            }

            $resNum = $this->wordToNumber($resultado, $candidates);
            if (strlen($resultado) !== strlen((string)$resNum)) {
                return false;
            };

            // verify if valid
            return $sum === $resNum;
        }

        $letter = $letters[$idx];

        for ($d = 0; $d <= 9; $d++) {
            if (isset($usedDigits[$d])) {
                continue;
            }
            if (isset($leadingLetters[$letter]) && $d === 0) {
                continue;
            }

            $candidates[$letter] = $d;
            $usedDigits[$d] = true;

            // Recursion
            if ($this->backtrack($idx + 1, $letters, $productos, $resultado, $candidates, $usedDigits, $leadingLetters)) {
                return true; // encontramos una solución, salimos
            }

            // remove
            unset($candidates[$letter]);
            unset($usedDigits[$d]);
        }

        // probamos todos los dígitos y ninguno funciona
        return false;
    }


    private function getUniqueLetters(string $puzzle): array
    {
        $onlyLetters = preg_replace('/[^A-Za-z]/', '', $puzzle); // "IBBILL"
        $chars = str_split($onlyLetters); // ['I','B','B','I','L','L']
        $arr = array_values(array_unique($chars)); // ['I','B','L']
        $dict = [];
        foreach ($arr as $val) {
            $dict[$val] = array_fill(0, 10, null);
        }
        return $dict;
    }
    private function getProductsAndResult(string $puzzle): array
    {
        list($left, $right) = array_map('trim', explode('==', $puzzle));
        $operands = array_map('trim', explode('+', $left));
        $result = trim($right);
        return [$operands, $result];
    }
}
