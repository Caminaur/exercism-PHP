<?php

declare(strict_types=1);

function saddlePoints(array $trees): array
{
    $solution = [];

    foreach ($trees as $rowKey => $row) {

        if (empty($row)) continue;
        $rowMax = max($row);

        foreach ($row as $columnKey => $tree) {
            $isBiggestInRow = $tree === $rowMax;
            $isSmallestInColumn = $tree === min(array_column($trees, $columnKey));

            if ($isBiggestInRow && $isSmallestInColumn) {
                $solution[] = [
                    "row"    => $rowKey + 1,
                    "column" => $columnKey + 1
                ];
            }
        }
    }

    return $solution;
}
