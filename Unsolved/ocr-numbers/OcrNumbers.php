<?php

declare(strict_types=1);


function OcrToString($ocr)
{
    if ($ocr === ["   ", "  |", "  |", "   "]) {
        return '1';
    } elseif ($ocr === [" _ ", " _|", "|_ ", "   "]) {
        return '2';
    } elseif ($ocr === [" _ ", " _|", " _|", "   "]) {
        return '3';
    } elseif ($ocr === ["   ", "|_|", "  |", "   "]) {
        return '4';
    } elseif ($ocr === [" _ ", "|_ ", " _|", "   "]) {
        return '5';
    } elseif ($ocr === [" _ ", "|_ ", "|_|", "   "]) {
        return '6';
    } elseif ($ocr === [" _ ", "  |", "  |", "   "]) {
        return '7';
    } elseif ($ocr === [" _ ", "|_|", "|_|", "   "]) {
        return '8';
    } elseif ($ocr === [" _ ", "|_|", " _|", "   "]) {
        return '9';
    } elseif ($ocr === [" _ ", "| |", "|_|", "   "]) {
        return '0';
    }
    return "?";
}


function recognize(array $input): string
{
    $chunkedArray = array_chunk($input, 4);
    if (count($chunkedArray[0]) < 4) {
        throw new InvalidArgumentException("Invalid amount of lines");
    }

    $numbersChunks = [];
    foreach ($chunkedArray as $t => $chunk) {
        foreach ($chunk as $key => $line) {
            $splittedRow = str_split($line, 3); //["   ", "   "]
            foreach ($splittedRow as $k => $v) {
                if (strlen($v) < 3) {
                    throw new InvalidArgumentException("Invalid amount of columns");
                }
                $numbersChunks[$t][$k][$key] = $v;
            }
        }
    }

    $result = '';
    foreach ($numbersChunks as $key => $nc) {
        foreach ($nc as $key => $n) {
            $result .= (string) OcrToString($n);
        }
        $result .= ",";
    }
    return rtrim($result, ',');
}

// "    _  _ ",
// "  | _| _|",
// "  ||_  _|",
// "         ",
// "    _  _ ",
// "|_||_ |_ ",
// "  | _||_|",
// "         ",
// " _  _  _ ",
// "  ||_||_|",
// "  ||_| _|",
// "         ",

// "   "
// "  |"
// "  |"
// "   "

// _ "
// _|"
//|_ "