<?php


function computeBestPrice(array $books, array &$memo = []): int
{
    // Create a unique key 11210
    $key = implode('', $books);

    // If we've already calculated the state, return result
    if (isset($memo[$key])) {
        return $memo[$key];
    }

    // No books left
    if (array_sum($books) === 0) {
        return 0;
    }

    $minPrice = PHP_INT_MAX;

    // Books groups Prices
    $prices = [
        1 => 800,
        2 => 1520,
        3 => 2160,
        4 => 2560,
        5 => 3000,
    ];

    // Get index of books that still have at least one copy
    $available = [];
    foreach ($books as $i => $count) {
        if ($count > 0) {
            $available[] = $i;
        }
    }

    $n = count($available);

    // Try forming groups from size 5 down to 1
    for ($groupSize = min(5, $n); $groupSize >= 1; $groupSize--) {

        // Generate all valid combinations of available books for this group size
        $combos = generateCombinations($available, $groupSize);

        foreach ($combos as $combo) {
            // Clone the current book state
            $newBooks = $books;

            // Remove one copy of each book in the selected combination
            foreach ($combo as $i) {
                $newBooks[$i]--;
            }

            // Recursively calculate the price for the remaining books
            $price = $prices[$groupSize] + computeBestPrice($newBooks, $memo);

            // Keep the minimum total price found
            $minPrice = min($minPrice, $price);
        }
    }

    // Store result in memo and return
    return $memo[$key] = $minPrice;
}

/**
 * Generates all combinations of the given elements of a specific size.
 * Used to explore all valid groupings of different books.
 *
 * Example:
 * generateCombinations([0,1,2], 2) => [[0,1], [0,2], [1,2]]
 */
function generateCombinations(array $elements, int $size): array
{
    if ($size === 0) return [[]];
    if (count($elements) < $size) return [];

    $result = [];

    for ($i = 0; $i <= count($elements) - $size; $i++) {
        $head = $elements[$i];
        $tail = array_slice($elements, $i + 1);
        foreach (generateCombinations($tail, $size - 1) as $combo) {
            array_unshift($combo, $head);
            $result[] = $combo;
        }
    }

    return $result;
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
    return computeBestPrice($booksByCategory);
}
