<?php

function getBestPrice(array $books): int
{
    $memo = [];
    return computeBestPrice($books, $memo);
}

function computeBestPrice(array $books, array &$memo): int
{
    // Key una para las combinaciones
    $key = implode('', $books);

    // Si existe retornar la existente y evitar el calculo
    if (isset($memo[$key])) {
        return $memo[$key];
    }

    // Si no hay libros retornar 0
    if (array_sum($books) === 0) {
        return 0;
    }

    $minPrice = PHP_INT_MAX;

    // precios en centavos
    $prices = [
        1 => 800,
        2 => 1520,
        3 => 2160,
        4 => 2560,
        5 => 3000,
    ];

    $indices = availableIndexes($books); // [2,3,4]
    $n = count($indices); // 3

    for ($groupSize = 1; $groupSize <= $n; $groupSize++) {
        $combinations = combinations($indices, $groupSize);
        foreach ($combinations as $combo) {
            $newBooks = $books;
            foreach ($combo as $i) {
                $newBooks[$i]--;
            }
            $price = $prices[$groupSize] + computeBestPrice($newBooks, $memo);
            $minPrice = min($minPrice, $price);
        }
    }

    return $memo[$key] = $minPrice;
}

function availableIndexes($books)
{
    $indices = [];
    foreach ($books as $index => $count) {
        if ($count > 0) {
            $indices[] = $index;
        }
    }
    return $indices;
}

function combinations(array $elements, int $size): array
{
    if ($size === 0) return [[]];
    if (empty($elements)) return [];

    $result = [];
    $head = $elements[0];
    $tail = array_slice($elements, 1);

    foreach (combinations($tail, $size - 1) as $combo) {
        array_unshift($combo, $head);
        $result[] = $combo;
    }

    return array_merge($result, combinations($tail, $size));
}


function organizeItems($items): array
{
    $array = array_fill(1, 5, 0);
    foreach ($items as $value) {
        $array[$value]++;
    }
    return $array;
}

function total(array $items): int
{
    $booksByCategory = organizeItems($items);
    return getBestPrice($booksByCategory);
}
