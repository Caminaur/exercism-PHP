<?php

declare(strict_types=1);

function encode(string $plainMessage, int $rails): string
{
    $response = '';
    $rails_container = [];

    for ($r = 0; $r < $rails; $r++) {
        $rails_container[] = "";
    }

    $id = -1;
    $direction = "DOWN";

    for ($m = 0; $m < strlen($plainMessage); $m++) {

        $letter = $plainMessage[$m];
        switch ($direction) {
            case 'DOWN':
                $id++;
                $rails_container[$id] .= $letter;
                if (!isset($rails_container[$id + 1])) {
                    $direction = "UP";
                    break;
                }
                break;
            default: // up
                $id--;
                $rails_container[$id] .= $letter;
                if ($id === 0) {
                    $direction = "DOWN";
                }
                break;
        }
    }

    foreach ($rails_container as $value) {
        $response .= $value;
    }

    return $response;
}

function decode_for_integer_k(string $cipherMessage, int $k): string
{
    $length = strlen($cipherMessage);
    $rails = (int) ($length / ($k * 2)) + 1;

    // Calcular lengths de rieles
    $rail_counts = array_fill(0, $rails, 0);
    $rail_index = -1;
    $direction = "DOWN";

    for ($i = 0; $i < $length; $i++) {
        if ($direction === "DOWN") {
            $rail_index++;
            $rail_counts[$rail_index]++;
            if ($rail_index === $rails - 1) {
                $direction = "UP";
            }
        } else {
            $rail_index--;
            $rail_counts[$rail_index]++;
            if ($rail_index === 0) {
                $direction = "DOWN";
            }
        }
    }

    // Separar Chunks
    $rails_container = [];
    $cursor = 0;
    for ($i = 0; $i < $rails; $i++) {
        $rails_container[$i] = str_split(substr($cipherMessage, $cursor, $rail_counts[$i]));
        $cursor += $rail_counts[$i];
    }

    $response = '';
    $rail_index = -1;
    $direction = "DOWN";

    for ($i = 0; $i < $length; $i++) {
        if ($direction === "DOWN") {
            $rail_index++;
            $response .= array_shift($rails_container[$rail_index]);
            if ($rail_index === $rails - 1) {
                $direction = "UP";
            }
        } else {
            $rail_index--;
            $response .= array_shift($rails_container[$rail_index]);
            if ($rail_index === 0) {
                $direction = "DOWN";
            }
        }
    }

    return $response;
}


function decode_for_float(string $cipherMessage, float $k, int $rails, int $length): string
{
    $rail_counts = array_fill(0, $rails, 0);
    $id = -1;
    $direction = "DOWN";

    // debemos correrlo para saber como deberian ser los chunks
    for ($i = 0; $i < $length; $i++) {
        if ($direction === "DOWN") {
            $id++;
            $rail_counts[$id]++;
            if ($id === $rails - 1) {
                $direction = "UP";
            }
        } else {
            $id--;
            $rail_counts[$id]++;
            if ($id === 0) {
                $direction = "DOWN";
            }
        }
    }

    // dividimos el mensaje
    $rails_container = [];
    $posicion = 0;
    for ($i = 0; $i < $rails; $i++) {
        $rails_container[$i] = str_split(substr($cipherMessage, $posicion, $rail_counts[$i]));
        $posicion += $rail_counts[$i];
    }

    $response = '';
    $id = -1;
    $direction = "DOWN";

    for ($i = 0; $i < $length; $i++) {
        if ($direction === "DOWN") {
            $id++;
            if ($id === $rails - 1) {
                $direction = "UP";
            }
        } else {
            $id--;
            if ($id === 0) {
                $direction = "DOWN";
            }
        }
        $response .= array_shift($rails_container[$id]);
    }

    return $response;
}


function decode(string $cipherMessage, int $rails): string
{
    $length = strlen($cipherMessage);
    $k = $length / (2 * ($rails - 1));

    if (is_int($k)) {
        return decode_for_integer_k($cipherMessage, $k);
    }
    return decode_for_float($cipherMessage, $k, $rails, $length);
}
