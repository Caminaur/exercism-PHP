<?php

declare(strict_types=1);

class Allergies
{
    private array $allergyList;
    public function __construct(int $score)
    {
        $this->allergyList = self::processScore($score % 256);
    }

    private function processScore(int $score)
    {
        if ($score === 0) {
            return [];
        }

        $allergensList = Allergen::allergenList();
        rsort($allergensList);

        $list = [];

        foreach ($allergensList as $a) {
            if ($score - $a->getScore() >= 0) {
                $list[] = $a;
                $score -= $a->getScore();
            }
        }
        return $list;
    }

    public function isAllergicTo(Allergen $allergen): bool
    {
        return in_array($allergen, $this->allergyList);
    }

    public function getList(): array
    {
        return $this->allergyList;
    }
}

class Allergen
{
    public const EGGS = 1;
    public const PEANUTS = 2;
    public const SHELLFISH = 4;
    public const STRAWBERRIES = 8;
    public const TOMATOES = 16;
    public const CHOCOLATE = 32;
    public const POLLEN = 64;
    public const CATS = 128;

    private int $score;

    public function __construct(int $score)
    {
        $this->score = $score;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function equals(Allergen $other): bool
    {
        return $this->score === $other->score;
    }

    public static function allergenList(): array
    {
        return [
            new Allergen(self::EGGS),
            new Allergen(self::PEANUTS),
            new Allergen(self::SHELLFISH),
            new Allergen(self::STRAWBERRIES),
            new Allergen(self::TOMATOES),
            new Allergen(self::CHOCOLATE),
            new Allergen(self::POLLEN),
            new Allergen(self::CATS),
        ];
    }
}
