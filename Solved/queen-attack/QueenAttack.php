<?php

declare(strict_types=1);

function placeQueen(int $xCoordinate, int $yCoordinate): bool
{
    if ($xCoordinate > 7 || $yCoordinate > 7) throw new InvalidArgumentException("The position must be on a standard size chess board.");
    if ($xCoordinate < 0 || $yCoordinate < 0) throw new InvalidArgumentException("The rank and file numbers must be positive.");

    return true;
}

function canAttack(array $w, array $b): bool
{
    placeQueen($w[0], $w[1]);
    placeQueen($b[0], $b[1]);

    $sameRank = $w[0] === $b[0];
    $sameFile = $w[1] === $b[1];
    if ($sameRank || $sameFile) return true;
    $isDiagonallAttackPossible = abs($w[0] - $b[0]) === abs($w[1] - $b[1]);
    return $isDiagonallAttackPossible;
}

// 8*8 array

# Queen movies horizontally, veritally, and diagonally

# PLACE QUEEN
# verify if the position is valid
# tomar nota en la fila de cada reina y en su index para calcular si es posible un ataque
# ejemplo 2 2 y 5 5

// 0 // 0 0 0 0 0 0 0 0
// 1 // 0 0 0 0 0 0 0 0
// 2 // 0 0 █ 0 0 0 0 0
// 3 // 0 0 0 0 0 0 0 0
// 4 // █ 0 0 0 0 0 0 0
// 5 // 0 0 0 0 0 0 0 0
// 6 // 0 0 0 0 0 0 0 0
// 7 // 0 0 0 0 0 0 0 0
//      0 1 2 3 4 5 6 7

// $this->assertTrue(canAttack([2, 2], [0, 4]));

# CUANDO PUEDE ATACARSE
# EQUAL ROW
# EQUAL IN
# |$FILE 1 - $FILE 2| === |$ROW 1 - $ROW 2|  

// Verificar si la distancia entre file 1 y 2 es igual a la distancia entre col 1 y 2 sea tanto positiva o negativa