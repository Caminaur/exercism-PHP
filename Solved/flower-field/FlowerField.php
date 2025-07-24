<?php

declare(strict_types=1);

class FlowerField
{
    private $garden;
    public function __construct(array $garden)
    {
        $this->garden = $garden;
    }

    public function annotate(): array
    {
        $rows = count($this->garden);
        $cols = isset($this->garden[0]) ? strlen($this->garden[0]) : '';

        $response = [];
        $lista_de_proximidad = [
            [-1, -1], // arriba izquierda
            [-1, 0],  // arriba
            [-1, 1],  // arriba derecha
            [0, -1],  // izquierda
            [0, 1],   // derecha
            [1, -1],  // abajo izquierda
            [1, 0],   // abajo
            [1, 1]    // abajo derecha
        ];

        foreach ($this->garden as $rowKey => $row) {
            $rowChars = str_split($row);
            $newRow = "";

            foreach ($rowChars as $columnKey => $cell) {
                if ($cell === "*") {
                    $newRow .= "*";
                    continue;
                }

                $counter = 0;
                foreach ($lista_de_proximidad as [$dx, $dy]) {
                    $newX = $rowKey + $dx;
                    $newY = $columnKey + $dy;

                    if ($newX < 0 || $newX >= $rows || $newY < 0 || $newY >= $cols) {
                        continue;
                    }

                    if ($this->garden[$newX][$newY] === "*") {
                        $counter++;
                    }
                }

                $newRow .= $counter !== 0 ? strval($counter) : " ";
            }
            $response[] = $newRow;
        }

        return $response;
    }
}
