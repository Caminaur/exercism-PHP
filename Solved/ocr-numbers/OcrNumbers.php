<?php

declare(strict_types=1);


function ocrToString(array $ocr): string
{
    static $map = [
        "     |  |   " => '1',
        " _  _||_    " => '2',
        " _  _| _|   " => '3',
        "   |_|  |   " => '4',
        " _ |_  _|   " => '5',
        " _ |_ |_|   " => '6',
        " _   |  |   " => '7',
        " _ |_||_|   " => '8',
        " _ |_| _|   " => '9',
        " _ | ||_|   " => '0',
    ];
    $key = implode('', $ocr);
    return $map[$key] ?? '?';
}

function processLine(string $line): array
{
    $splittedRow = str_split($line, 3);

    foreach ($splittedRow as $numberPortion) {
        if (strlen($numberPortion) < 3) {
            throw new InvalidArgumentException("Invalid amount of columns");
        }
    }

    return $splittedRow;
}

function convertChunksToString(array $numbersChunks): string
{
    $result = '';

    foreach ($numbersChunks as $group) {
        foreach ($group as $n) {
            $result .= (string) ocrToString($n);
        }
        $result .= ',';
    }

    return rtrim($result, ',');
}

function recognize(array $input): string
{
    $chunkedArray = array_chunk($input, 4);
    if (count($chunkedArray[0]) < 4) {
        throw new InvalidArgumentException("Invalid amount of lines");
    }

    $numbersChunks = [];
    foreach ($chunkedArray as $groupIndex => $groupOfLines) { // 4 lines group that form the number / symbol
        foreach ($groupOfLines as $lineIndex => $line) { // each individual line that contains every level of the rows
            foreach (processLine($line) as $columnIndex => $chunk) { // Every 3 chars that represent a portion of the number
                $numbersChunks[$groupIndex][$columnIndex][$lineIndex] = $chunk;
            }
        }
    }


    return convertChunksToString($numbersChunks);
}
