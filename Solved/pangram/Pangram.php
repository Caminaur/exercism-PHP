<?php

declare(strict_types=1);

function isPangram(string $string): bool
{
    $string = str_replace(" ", "", $string);

    $arr = str_split($string);
    $dict = array_flip(range("a", "z"));
    $dict = array_map(fn($_) => 0, $dict);

    foreach ($arr as $buchstabe) {
        $buchstabe = strtolower($buchstabe);
        if (isset($dict[$buchstabe])) {
            $dict[$buchstabe] = 1;
        }
    }

    return (bool)min($dict);
}
