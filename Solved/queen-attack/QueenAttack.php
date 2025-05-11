<?php

declare(strict_types=1);

/**
 * Validates the position of a queen in a 8x8 chess board.
 * 
 * @param int $xCoordinate 0 to 7.
 * @param int $yCoordinate 0 to 7.
 * @return bool Returns true if the position is valid.
 * @throws InvalidArgumentException If coordinates are outside of the valid range.
 */
function placeQueen(int $xCoordinate, int $yCoordinate): bool
{
    if ($xCoordinate > 7 || $yCoordinate > 7) {
        throw new InvalidArgumentException("The position must be on a standard size chess board.");
    }
    if ($xCoordinate < 0 || $yCoordinate < 0) {
        throw new InvalidArgumentException("The rank and file numbers must be positive.");
    }

    return true;
}

/**
 * Determines whether two queens can attack each other on a chess board
 * 
 * @param array $w Coordinates of the White queen [X,Y].
 * @param array $b Coordinates of the Black queen [X,Y].
 * @return bool Returns true if the queen can attack each other and returns false otherwise .
 */
function canAttack(array $w, array $b): bool
{
    placeQueen($w[0], $w[1]);
    placeQueen($b[0], $b[1]);

    $sameRank = $w[0] === $b[0];
    $sameFile = $w[1] === $b[1];
    $sameDiagonal = abs($w[0] - $b[0]) === abs($w[1] - $b[1]);

    return $sameRank || $sameFile || $sameDiagonal;
}
