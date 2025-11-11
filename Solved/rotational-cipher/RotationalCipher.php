<?php

declare(strict_types=1);

class RotationalCipher
{
    private const DICT = [
        0 => 'a',
        1 => 'b',
        2 => 'c',
        3 => 'd',
        4 => 'e',
        5 => 'f',
        6 => 'g',
        7 => 'h',
        8 => 'i',
        9 => 'j',
        10 => 'k',
        11 => 'l',
        12 => 'm',
        13 => 'n',
        14 => 'o',
        15 => 'p',
        16 => 'q',
        17 => 'r',
        18 => 's',
        19 => 't',
        20 => 'u',
        21 => 'v',
        22 => 'w',
        23 => 'x',
        24 => 'y',
        25 => 'z',
    ];

    public function rotate(string $text, int $shift): string
    {
        $response = '';
        $arr = str_split($text);
        foreach ($arr as $value) {
            $response .= $this->rotateLetter($value, $shift);
        }
        return $response;
    }

    private function rotateLetter(string $value, int $shift)
    {
        $isUpperCase = ctype_upper($value);
        $lowerValue = strtolower($value);
        $oldKey = array_search($lowerValue, self::DICT, true);
        if ($oldKey === false) {
            return $value;
        }
        $newKey = ($oldKey + $shift) % 26;

        if ($isUpperCase) {
            return strtoupper(self::DICT[$newKey]);
        }
        return self::DICT[$newKey];
    }
}
