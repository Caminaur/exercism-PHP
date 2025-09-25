<?php

declare(strict_types=1);

class Alphametics
{
    public function solve(string $puzzle): ?array
    {
        // 'I + BB == ILL'
        preg_match_all("/([A-Z]+)(?=\s+\+|\s+==)/", $puzzle, $matches);
        preg_match("/(?<===\s)([A-Z]+)/", $puzzle, $result);

        $items = $matches[1]; // [I , BB]
        $result = $result[1];

        $dictionary = array_fill(0, 10, NULL);
        if (strlen($result) > max(array_map('strlen', $items))) {
            $dictionary[1] = $result[0];
        }
        var_dump($dictionary);
        die;
        return [];
    }
}

// maximo 10 letras distintas
// array(10) {
//   [0]=>
//   NULL
//   [1]=>
//   string(1) "I"
//   [2]=>
//   NULL
//   [3]=>
//   NULL
//   [4]=>
//   NULL
//   [5]=>
//   NULL
//   [6]=>
//   NULL
//   [7]=>
//   NULL
//   [8]=>
//   NULL
//   [9]=>
//   NULL
// }