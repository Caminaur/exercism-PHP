<?php

declare(strict_types=1);

class Minesweeper
{
    public array $minefield;
    public function __construct(array $minefield)
    {
        $this->minefield = $minefield;
    }

    public function annotate(): array
    {
        $directions = [
            [-1,-1], // top left
            [-1,0], // top
            [-1,1], // top right
            [0,-1], // left 
            [0,0], // center not needed
            [0,1], // right
            [1,-1], // bottom left
            [1,0], // bottom center
            [1,1], // bottom right
        ];

        $minefield = array_map(function($v){
            $arr = str_split($v);
            return $arr;
        },$this->minefield);

        // we format the array
        // [
        // "[' ',' ','*',' ',' ']",
        // "[' ',' ','*',' ',' ']",
        // "['*','*','*','*','*']",
        // "[' ',' ','*',' ',' ']",
        // "[' ',' ','*',' ',' ']",
        // ]

        $response = [];
        // Every line
        for ($i=0; $i < count($minefield) ; $i++) { 
            $string = '';
            // Every position
            for ($p=0; $p < count($minefield[$i]); $p++) { 
                if ($minefield[$i][$p]!=="*") {
                    $counter = 0;
                    // we check every direction
                    foreach ($directions as $direction) {
                        $isDirectionValid = isset($minefield[$i + $direction[0]][$p+$direction[1]]);
                        if ($isDirectionValid) {
                            if ($minefield[$i + $direction[0]][$p+$direction[1]] == "*") {
                                $counter++;
                            }
                        }
                    }
                    $s = ($counter > 0) ? $counter : " "; 

                    $string .= $s;
                } else{
                    $string .= "*";
                }
            }
            $response[]=$string;
        }
        return $response;
    }
}
