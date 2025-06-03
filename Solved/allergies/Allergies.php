<?php

declare(strict_types=1);

class Allergies
{
    private array $allergyList;
    public function __construct(int $score)
    {
        $this->allergyList = self::processScore($score);
    }

    private function processScore(int $score)
    {
        $list = [];

        $allergensList = Allergen::allergenList();
        usort($allergensList, fn($a, $b) => $b->getScore() <=> $a->getScore());



        foreach ($allergensList as $a) {
            // Bitwise comparison 
            if ($score & $a->getScore()) {
                $list[] = $a;
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
    public const EGGS = 1;           // 00000001
    public const PEANUTS = 2;        // 00000010
    public const SHELLFISH = 4;      // 00000100
    public const STRAWBERRIES = 8;   // 00001000
    public const TOMATOES = 16;      // 00010000
    public const CHOCOLATE = 32;     // 00100000
    public const POLLEN = 64;        // 01000000
    public const CATS = 128;         // 10000000

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


/*
|--------------------------------------------------------------------------
| Notas sobre Bitwise y representación de alergias
|--------------------------------------------------------------------------
|
| 1. Cada alergeno se representa como una potencia de 2:
|    EGGS         = 1    (00000001)
|    PEANUTS      = 2    (00000010)
|    SHELLFISH    = 4    (00000100)
|    STRAWBERRIES = 8    (00001000)
|    TOMATOES     = 16   (00010000)
|    CHOCOLATE    = 32   (00100000)
|    POLLEN       = 64   (01000000)
|    CATS         = 128  (10000000)
|
| 2. El score de alergias es un número que puede tener varios bits activados.
|    Por ejemplo:
|    Score = 5 → 00000101 → alérgico a EGGS (1) y SHELLFISH (4)
|
| 3. Operador bitwise &
|    - Sirve para verificar si un alérgeno está presente en el score.
|    - Ejemplo: (score & allergen) > 0  → ese alérgeno está presente.
|    - No es necesario modificar el score con restas si usás '&'.
|
| 4. Por qué % 256:
|    - Limita el score a los primeros 8 bits (0 a 255).
|    - Así ignoramos bits no relacionados con alergias válidas.
|
| 5. Ventajas:
|    - Código eficiente y claro.
|    - Permite representar múltiples flags (alérgenos) en un solo número.
|    - Fácil de escalar si se agregan más alérgenos (2^n).
|
*/
