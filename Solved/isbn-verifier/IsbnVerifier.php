<?php

declare(strict_types=1);

class IsbnVerifier
{
    public function isValid(string $str): bool
    {
        $str = str_split(str_replace('-', '', $str));
        $length = count($str);
        if ($length !== 10) {
            return false;
        }
        $sum = 0;
        $a = 1;
        for ($i = $length; $i > 0; $i--) {
            $number = $str[$i - 1];
            if (strtolower($number) === "x" && $i === $length) {
                $val = 10;
            } else {
                if (ctype_alpha($number)) {
                    return false;
                }
                $val = (int)$number;
            }
            $sum += $val * $a;
            $a++;
        }
        return $sum % 11 === 0;
    }
}
