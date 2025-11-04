<?php

declare(strict_types=1);

class Yacht
{
    public function score(array $rolls, string $category): int
    {
        $score = match ($category) {
            "ones" => $this->sumDigits($rolls, 1),
            "twos" => $this->sumDigits($rolls, 2),
            "threes" => $this->sumDigits($rolls, 3),
            "fours" => $this->sumDigits($rolls, 4),
            "fives" => $this->sumDigits($rolls, 5),
            "sixes" => $this->sumDigits($rolls, 6),
            "full house" => $this->fullHouse($rolls),
            "four of a kind" => $this->fourOfAKind($rolls),
            "little straight" => $this->verifyStraight($rolls, 'LITTLE'),
            "big straight" => $this->verifyStraight($rolls, 'BIG'),
            "choice" => array_sum($rolls),
            "yacht" => $this->verifyYacht($rolls),
            default => 0
        };

        return $score;
    }

    private function sumDigits(array $rolls, int $number): int
    {
        $score = 0;
        foreach ($rolls as $val) {
            if ($val === $number) {
                $score += $val;
            }
        }
        return $score;
    }
    private function verifyYacht(array $rolls): int
    {
        $countedVals = array_count_values($rolls);
        return max($countedVals) == 5 ? 50 : 0;
    }
    private function fullHouse(array $rolls): int
    {
        $countedVals = array_count_values($rolls);
        if (max($countedVals) === 3 && min($countedVals) === 2) {
            return array_sum($rolls);
        }
        return 0;
    }
    private function fourOfAKind(array $rolls): int
    {
        $countedVals = array_count_values($rolls);
        $maxValue = max($countedVals);
        $maxKey = array_search($maxValue, $countedVals);
        if (max($countedVals) >= 4) {
            return $maxKey * 4;
        }
        var_dump($countedVals);
        return 0;
    }
    private function verifyStraight(array $rolls, string $type = "LITTLE"): int
    {
        sort($rolls);
        $previousDice = '';
        $straightLength = 0;
        foreach ($rolls as $dice) {
            if ($straightLength === 0) {
                $previousDice = $dice;
                $straightLength++;
            } else {
                $isNextNumber = ($previousDice + 1) === $dice;
                if ($isNextNumber) {
                    $straightLength++;
                }
                $previousDice = $dice;
            }
        }
        if ($straightLength < 5) {
            return 0;
        }
        if ($type === "LITTLE") {
            return min($rolls) === 1 ? 30 : 0;
        }
        return min($rolls) === 2 ? 30 : 0;
    }
}
