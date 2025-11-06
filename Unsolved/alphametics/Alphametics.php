<?php

declare(strict_types=1);

class Alphametics
{
    public function solve(string $puzzle): ?array
    {
        // 'I + BB == ILL'
        $puzzle = 'I + BB == ILL';
        preg_match_all("/([A-Z]+)(?=\s+\+|\s+==)/", $puzzle, $matches);
        preg_match("/(?<===\s)([A-Z]+)/", $puzzle, $result);

        $items = $matches[1]; // [I , BB]
        $resultado = [];
        $candidates = [];

        [$productosASumar, $candidates] = $this->organizeProducts($items, $candidates);
        // $productosASumar = [
        //     // producto 1
        //     0 => [
        //         //partes del producto 1
        //         0 =>[
        //             'letra' => 'I'
        //             'val' => [0=>NULL,1=>NULL,...9=>NULL];
        //         ],
        //     ],
        //     // producto 2
        //     1 => [
        //         //partes del producto 2
        //         0 =>[
        //             'letra' => 'B'
        //             'val' => [0=>NULL,1=>NULL,...9=>NULL];
        //         ],
        //         1 =>[
        //             'letra' => 'B'
        //             'val' => [0=>NULL,1=>NULL,...9=>NULL];
        //         ],
        //     ],
        // ]
        [$resultado, $candidates] = $this->organizeProducts(str_split($result[0]), $candidates);

        $result = $result[1];
        $productosASumar[$result] = array_fill(0, 10, NULL);

        // var_dump($productosASumar);
        echo json_encode($productosASumar, JSON_PRETTY_PRINT);


        $lala = $this->testCandidates($candidates, $productosASumar, $result);

        die;

        $dictionary = array_fill(0, 10, NULL);
        if (strlen($result) > max(array_map('strlen', $items))) {
            $dictionary[1] = $result[0];
        }
        var_dump($items, $result);
        die;
        return [];
    }

    private function organizeProducts(array $arr, array $response): array
    {
        $productosASumar = [];
        foreach ($arr as $key => $value) {
            $split = str_split($value);
            $producto[$key] = [];
            foreach ($split as $v) {
                $producto[$key][] = ['letter' => $v, 'val' => array_fill(0, 10, NULL)];
                $response[$v] = NULL;
            }
            $productosASumar[] = $producto[$key];
        }
        return [$productosASumar, $response];
    }

    private function testCandidates(array $candidates, array $productosASumar, array $result): bool {}
}
// $word1 - SEND
// $word2 - MORE
// $result - MONEY
//
//
// maximo 10 letras distintas
// $word1 {
//     S => [1,2,3,4,5,6,7,8,9], // first one no zeros
//     E => [0,1,2,3,4,5,6,7,8,9],
//     N => [0,1,2,3,4,5,6,7,8,9],
//     D => [0,1,2,3,4,5,6,7,8,9],
// }
// $word2 {
//     M => [1,2,3,4,5,6,7,8,9],
//     O => [0,1,2,3,4,5,6,7,8,9],
//     R => [0,1,2,3,4,5,6,7,8,9],
//     E => [0,1,2,3,4,5,6,7,8,9],
// }
// $result {
//     M => [1,2,3,4,5,6,7,8,9],
//     O => [0,1,2,3,4,5,6,7,8,9],
//     N => [0,1,2,3,4,5,6,7,8,9],
//     E => [0,1,2,3,4,5,6,7,8,9],
//     Y => [0,1,2,3,4,5,6,7,8,9],
// }

// If we calculate a number we should remove it from all the other lists or complete it in case its necesary
// If result length > word1 or word2 length 
    // 1st letter of result should be 1
// we try all combinations removing if its not possible
// Every digit should be tested by value X and X+1 in case there's some carrying from the sum
// like 1   6  0 
//     +2   5  6
//      ________
//      4   1  6
//     +1  +1  0
