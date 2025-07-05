<?php

class LuckyNumbers
{
    public function sumUp(array $digitsOfNumber1, array $digitsOfNumber2): int
    {
        $number1 = $this->buildNumber($digitsOfNumber1);
        $number2 = $this->buildNumber($digitsOfNumber2);
        return $number1 + $number2;
    }

    public function isPalindrome(int $number): bool
    {
        return strrev((string)$number) === (string)$number;
    }

    public function validate(string $input): string
    {
        if ($input === '') {
            return 'Required field';
        }
        if ((int)$input <= 0) {
            return 'Must be a whole number larger than 0';
        }
        return '';
    }

    private function buildNumber(array $array): int
    {
        $string = '';
        foreach ($array as $v) {
            $string .= (string)$v;
        }
        return (int)$string;
    }
}
