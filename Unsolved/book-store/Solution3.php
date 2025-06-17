<?php
// solution taken from Zembrowski
const BOOK_PRICE = 8.00;
const DISCOUNTS = [
    1 => 0.00,
    2 => 0.05,
    3 => 0.10,
    4 => 0.20,
    5 => 0.25,
];
function total(array $basket): float
{
    return (int) price(array_count_values($basket));
}
function price(array $book_counts): float
{
    $results = [];
    $max_title_count = count($book_counts);
    for ($title_count = 1; $title_count <= $max_title_count; $title_count++) {
        $discount = BOOK_PRICE - (BOOK_PRICE * DISCOUNTS[$title_count]);
        $results[] = $title_count * $discount + price(decr($book_counts, $title_count));
    }
    return [] === $book_counts ? 0 : min($results);
}
function decr(array $book_counts, int $n): array
{
    while ($n-- > 0) {
        --$book_counts[key($book_counts)];
        next($book_counts);
    }
    return array_filter($book_counts);
}
