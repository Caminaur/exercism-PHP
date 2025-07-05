<?php


declare(strict_types=1);
// "t h e r a p y"

const VOWELS = ['a', 'e', 'i', 'o', 'u'];
const CONSONANTS = [
    'b',
    'c',
    'd',
    'f',
    'g',
    'h',
    'j',
    'k',
    'l',
    'm',
    'n',
    'p',
    'q',
    'r',
    's',
    't',
    'v',
    'w',
    'x',
    'y',
    'z'
];

function moveConsonantsToTheBack($textSplit)
{
    $lettersToMove = [];
    $vocalFound = false;
    foreach ($textSplit as $letter) {
        if (in_array($letter, VOWELS)) {
            $vocalFound = true;
        }
        if (!$vocalFound) {
            $lettersToMove[] = $letter;
        }
    }
    $textSplit = array_slice($textSplit, count($lettersToMove));
    return implode("", array_merge($textSplit, $lettersToMove));
}

function moveConsonantsAndYToTheBack($textSplit)
{
    foreach ($textSplit as $letter) {
        if ($letter === "y") {
            break;
        }
        array_shift($textSplit);
        $textSplit[] = $letter;
    }
    return implode("", $textSplit);
}

function translateWord(string $text): string
{
    $text = strtolower($text);
    $textSplit = str_split($text, 1);

    // rule 1
    $beginsWithVowel = in_array($textSplit[0], VOWELS);
    $yt = ($textSplit[0] . $textSplit[1]) === "yt";
    $xr = ($textSplit[0] . $textSplit[1]) === "xr";
    $rule1 = $beginsWithVowel || $yt || $xr;
    if ($rule1) {
        $text .= "ay";
        return $text;
    }

    $beginsWithConsonants = in_array($textSplit[0], CONSONANTS);
    $rule2 = $beginsWithConsonants;
    $beginsWithQu = ($textSplit[0] . $textSplit[1]) === "qu";
    if ($beginsWithQu) { // rule 3.1
        array_shift($textSplit);
        array_shift($textSplit);
        $textSplit[] = "q";
        $textSplit[] = "u";
        $text = implode($textSplit);
        $text .= "ay";
        return $text;
    }
    if ($rule2) {
        $continuesWithQu = $textSplit[1] === "q" && $textSplit[2] === "u";
        if ($continuesWithQu) { // rule 3.2
            $firstLetter = $textSplit[0];
            array_shift($textSplit);
            array_shift($textSplit);
            array_shift($textSplit);
            $textSplit[] = $firstLetter;
            $textSplit[] = "q";
            $textSplit[] = "u";
            $text = implode($textSplit);
        } elseif (consonantsFollowByY($textSplit)) { // rule 4
            $text = moveConsonantsAndYToTheBack($textSplit);
        } else {
            $text = moveConsonantsToTheBack($textSplit);
        }
        $text .= "ay";
        return $text;
    }
    return $text;
}

function translate(string $text): string
{
    $translation = '';
    $words = explode(" ", $text);
    foreach ($words as $word) {
        $translation .= translateWord($word) . " ";
    }
    return trim($translation);
}

function consonantsFollowByY($textSplit)
{
    $foundConsonant = false;

    foreach ($textSplit as $i => $letter) {
        if (in_array($letter, VOWELS)) {
            return false;
        }
        if ($letter === 'y' && $foundConsonant) {
            return true;
        }
        if (in_array($letter, CONSONANTS)) {
            $foundConsonant = true;
        }
    }

    return false;
}
