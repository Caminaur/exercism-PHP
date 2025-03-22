<?php

declare(strict_types=1);


// ". O . .",
// "O X X X",
// "O X O .",
// "X X O X",
// ". O X .",

function depthFirstSearch($board, $player, &$visited, $x, $y, $objective, $height, $width){

    if ($objective == 'bottom' && $y == $height - 1) return true; // si O llego a la posicion final
    if ($objective == 'right' && $x == $width - 1) return true; // si X llego a la posicion final

    $visited[$y][$x] = true;

    $lista_de_proximidad = [
        [-1, 0], // arriba
        [-1, 1], // arriba derecha
        [0, -1], // izquierda
        [0, 1], // derecha
        [1, -1], // abajo izquierda
        [1, 0] // abajo
    ];
    
    foreach ($lista_de_proximidad as [$dx,$dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;

        $nx_is_valid_position = $nx >=0 && $nx < $width;
        $ny_is_valid_position = $ny >=0 && $ny < $height;
        if ($nx_is_valid_position && $ny_is_valid_position) {
            $is_mismo_valor = $board[$ny][$nx] == $player;
            $was_not_visited = !$visited[$ny][$nx];
            if ($was_not_visited && $is_mismo_valor) {
                if (depthFirstSearch($board, $player, $visited, $nx, $ny, $objective, $height, $width)) {
                    return true;
                }
            }
        }
    }

}
function winner(array $lines): ?string
{
    $width = strlen(trim($lines[0]));

    $y_group = count($lines);
    $x_group_length = (($width - 1)/2) + 1;

    // normalize board
    $board = (function()use($lines){
        $new_array = [];
        // remove white spaces
        foreach ($lines as $l) {
            $cols = str_split(str_replace(' ',"",$l));
            $col_array = [];
            foreach($cols as $col){
                $col_array[] = $col;
            }
            $new_array[] = $col_array;
        }
        return $new_array;
    })();
    // buscamos el camino por O
    $visited = array_fill(0,$x_group_length,false);
    for ($x=0; $x < $x_group_length ; $x++) { 
        if ($board[0][$x] == 'O' && depthFirstSearch($board, 'O', $visited, $x, 0, 'bottom', $y_group, $x_group_length)) {
            return 'white';
        }
    }


    // Buscar camino para 'X' de izquierda a derecha
    $visited = array_fill(0, $y_group, array_fill(0, $width, false));
    for ($y = 0; $y < $y_group; $y++) {
        if ($board[$y][0] == 'X' && depthFirstSearch($board, 'X', $visited, 0, $y, 'right', $y_group, $x_group_length)) {
            return 'black';
        }
    }

    // No winner
    return "";
}
