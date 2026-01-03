<?php

declare(strict_types=1);

class FoodChain
{
    private const ANIMALS = [
        1 => 'fly',
        2 => 'spider',
        3 => 'bird',
        4 => 'cat',
        5 => 'dog',
        6 => 'goat',
        7 => 'cow',
        8 => 'horse',
    ];
    private const SPIDER_EXTRA_VERSE = " that wriggled and jiggled and tickled inside her.";
    private const LAST_VERSE = "I don't know why she swallowed the fly. Perhaps she'll die.";

    public function verse(int $verseNumber): array
    {
        $animal = self::ANIMALS[$verseNumber];

        $response = [
            $this->getFirstVerse($animal),
            $this->getSecondVerse($animal),
        ];

        if ($verseNumber === 1 || $verseNumber === 8) {
            return $response;
        }

        while ($verseNumber > 1) {
            $cAnimal = self::ANIMALS[$verseNumber];
            $pAnimal = self::ANIMALS[$verseNumber - 1];

            $text = "She swallowed the {$cAnimal} to catch the {$pAnimal}";

            $text .= match ($pAnimal) {
                "spider" => self::SPIDER_EXTRA_VERSE,
                default => ".",
            };

            $response[] = $text;
            $verseNumber--;
        }
        $response[] = self::LAST_VERSE;
        return $response;
    }

    private function getFirstVerse(string $animal): string
    {
        return "I know an old lady who swallowed a {$animal}.";
    }
    private function getSecondVerse(string $animal): string
    {
        return match ($animal) {
            'fly'    => "I don't know why she swallowed the fly. Perhaps she'll die.",
            'spider' => "It wriggled and jiggled and tickled inside her.",
            'bird'   => "How absurd to swallow a bird!",
            'cat'    => "Imagine that, to swallow a cat!",
            'dog'    => "What a hog, to swallow a dog!",
            'goat'   => "Just opened her throat and swallowed a goat!",
            'cow'    => "I don't know how she swallowed a cow!",
            'horse'  => "She's dead, of course!",
        };
    }
    public function verses(int $start, int $end): array
    {
        $response = [];
        for ($i = $start; $i <= $end; $i++) {
            $verse = $this->verse($i);
            $response = array_merge($response, $verse);
            if ($i !== $end) {
                $response[] = '';
            }
        }
        return $response;
    }

    public function song(): array
    {
        return $this->verses(1, 8);
    }
}
