<?php


function computeBestPrice(array $books, array &$memo = []): int
{
    $books = normalize($books); // ensure normalized state

    // No books left
    if (array_sum($books) === 0) {
        return 0;
    }

    // Create a unique key 11210
    $key = implode('', $books);
    // If we've already calculated the state, return result
    if (isset($memo[$key])) {
        return $memo[$key];
    }

    $n = count($books);
    $minPrice = PHP_INT_MAX;

    // Books groups Prices
    $prices = [
        1 => 800,
        2 => 1520,
        3 => 2160,
        4 => 2560,
        5 => 3000,
    ];


    // Try forming groups from groupSize down to 1
    for ($groupSize = $n; $groupSize >= 1; $groupSize--) {
        $remaining = removeGroupOfSizeFrom($books, $groupSize);
        $price = $prices[$groupSize] + computeBestPrice($remaining, $memo);
        if ($price < $minPrice) $minPrice = $price;
    }

    // Store result in memo and return
    return $memo[$key] = $minPrice;
}

/**
 * Removes zeros and sorts descending to have a canonical state.
 */
function normalize(array $books): array
{
    // Step 1: remove all zero values
    $filtered = array_filter($books, fn($x) => $x > 0);
    // Step 2: reindex the array so keys start from 0
    $books = array_values($filtered);

    rsort($books, SORT_NUMERIC); // descending
    return $books;
}

/**
 * Subtracts 1 from the first $groupSize categories (since it's sorted desc),
 * then normalizes.
 */
function removeGroupOfSizeFrom(array $books, int $groupSize): array
{
    for ($i = 0; $i < $groupSize; $i++) {
        $books[$i]--;
    }
    return normalize($books);
}

/**
 * Counts how many copies there are of each book in the input list.
 * Returns an array where each value represents the number of copies
 * of a specific title.
 *
 * Example:
 * organizeItems([1,1,2,2,3,3,4,5])
 * // Returns: [2,2,2,1,1]
 */
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
