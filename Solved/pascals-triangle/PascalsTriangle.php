<?php

declare(strict_types=1);

function pascalsTriangleRows(int $rowCount): array
{
    $pascalTriange = [];
    for ($row = 0; $row < $rowCount; $row++) {
        $width = $row;
        $line = [];
        for ($column = 0; $column <= $row; $column++) {
            if ($column === 0 || $column === $width) {
                $line[] = 1;
            } else {
                $line[] = $pascalTriange[$row - 1][$column - 1] + $pascalTriange[$row - 1][$column];
            }
        }
        $pascalTriange[] = $line;
    }
    return $pascalTriange;
}
