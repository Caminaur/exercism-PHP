<?php

declare(strict_types=1);

class Matrix
{
    private $matrix;
    public function __construct(string $matrix)
    {
        $this->matrix = $this->filterText($matrix);
    }

    private function filterText(string $text): array
    {
        $lines = explode("\n", trim($text));
        return array_map(function ($row) {
            return array_map('intval', explode(" ", $row));
        }, $lines);
    }

    public function getRow(int $rowId): array
    {
        return $this->matrix[$rowId - 1];
    }

    public function getColumn(int $columnId): array
    {
        $column = [];
        foreach ($this->matrix as $row) {
            $column[] = $row[$columnId - 1];
        }
        return $column;
    }
}
