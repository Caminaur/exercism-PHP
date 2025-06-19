<?php

declare(strict_types=1);

class DndCharacter
{
    public int $strength;
    public int $dexterity;
    public int $constitution;
    public int $intelligence;
    public int $wisdom;
    public int $charisma;
    public int $hitpoints;

    public static function modifier(int $modifier): int
    {
        return (int) floor(($modifier - 10) / 2);
    }

    public static function ability(): int
    {
        $rolls = [];
        for ($i = 0; $i < 4; $i++) {
            $rolls[] = self::rollDice();
        }
        sort($rolls);
        array_shift($rolls);
        return array_sum($rolls);
    }
    private static function rollDice(): int
    {
        return rand(1, 6);
    }

    public static function generate(): self
    {
        $character = new self();

        $character->strength = self::ability();
        $character->dexterity = self::ability();
        $character->constitution = self::ability();
        $character->intelligence = self::ability();
        $character->wisdom = self::ability();
        $character->charisma = self::ability();
        $character->hitpoints = 10 + self::modifier($character->constitution);

        return $character;
    }
}
