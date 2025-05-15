<?php

declare(strict_types=1);

const LETTER_SCORES = [
    'A' => 1,
    'E' => 1,
    'I' => 1,
    'O' => 1,
    'U' => 1,
    'L' => 1,
    'N' => 1,
    'R' => 1,
    'S' => 1,
    'T' => 1,
    'D' => 2,
    'G' => 2,
    'B' => 3,
    'C' => 3,
    'M' => 3,
    'P' => 3,
    'F' => 4,
    'H' => 4,
    'V' => 4,
    'W' => 4,
    'Y' => 4,
    'K' => 5,
    'J' => 8,
    'X' => 8,
    'Q' => 10,
    'Z' => 10,
];

/**
 * Calculates the score of a specific word in Scrabble
 * 
 * @param string $word It's the word to analyze.
 * @throws InvalidArgumentException If the word contains invalid characters.
 * @return int The points obtained
 */
function score(string $word): int
{
    $score = 0;
    $letters = str_split(strtoupper($word));

    foreach ($letters as $letter) {
        $points = LETTER_SCORES[$letter] ?? NULL;
        if ($points === NULL) {
            throw new InvalidArgumentException("The word contains invalid characters!");
        }
        $score += $points;
    }

    return $score;
}
