<?php

declare(strict_types=1);

function calculate(string $input): int
{
    preg_match_all('/-?\d+|[a-z]+(?: [a-z]+)?/i', $input, $matches);

    $tokens = $matches[0];

    if (empty($tokens)) throw new InvalidArgumentException("No valid input");

    $response = (int)$tokens[1];

    for ($i = 2; $i < count($tokens); $i += 2) {
        $operator = $tokens[$i] ?? null;
        $next_number = isset($tokens[$i + 1]) ? (int)$tokens[$i + 1] : null;

        switch ($operator) {
            case 'multiplied by':
                $response *= $next_number;
                break;
            case 'divided by':
                $response = $response / $next_number;
                break;
            case 'minus':
                $response -= $next_number;
                break;
            case 'plus':
                $response += $next_number;
                break;
            default:
                throw new InvalidArgumentException("Invalid argument");
        }
    }

    return $response;
}

# String con operaciones matematicas
# Dividirlo en las operaciones  
# tomar en cuenta multiplied by, minus, plus, divided by, etc. Como valid blocks

# Evtl. REGEX 
    # Take first number
    # Take words between first number and second number 
    # If longer continue until its over
    # (-?\d+)(.*?)(-?\d+)