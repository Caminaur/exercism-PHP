<?php

declare(strict_types=1);

class House
{
    private const lyrics = [
        "that lay in the house that Jack built.",
        "that ate the malt",
        "that killed the rat",
        "that worried the cat",
        "that tossed the dog",
        "that milked the cow with the crumpled horn",
        "that kissed the maiden all forlorn",
        "that married the man all tattered and torn",
        "that woke the priest all shaven and shorn",
        "that kept the rooster that crowed in the morn",
        "that belonged to the farmer sowing his corn",
        "This is the horse and the hound and the horn"
    ];


    public function verse(int $verseNumber): array
    {
        $newVerses = [];
        for ($i = $verseNumber - 1; $i >= 0; $i--) {
            $verse = self::lyrics[$i];
            if ($i === $verseNumber - 1) {
                $verse = preg_replace('/that.*?(?=the)/', "This is ", $verse, 1);
            }
            $newVerses[] = $verse;
        }
        return $newVerses;
    }

    public function verses(int $start, int $end): array
    {
        $newVerses = [];
        for ($i = $start; $i <= $end; $i++) {
            if ($i !== $start) {
                $newVerses = array_merge($newVerses, [''], $this->verse($i));
            } else {
                $newVerses = array_merge($newVerses, $this->verse($i));
            }
        }
        return $newVerses;
    }
}
