<?php

declare(strict_types=1);

class ZebraPuzzle
{
    private array $solucion;

    public function __construct()
    {
        $this->solucion = $this->resolver();
    }

    public function waterDrinker(): string
    {
        $casa = array_search('water', $this->solucion['bebidas']);
        return $this->solucion['nacionalidades'][$casa];
    }

    public function zebraOwner(): string
    {
        $casa = array_search('zebra', $this->solucion['mascotas']);
        return $this->solucion['nacionalidades'][$casa];
    }

    private function resolver(): array
    {
        foreach ($this->permutaciones(['red', 'green', 'ivory', 'yellow', 'blue']) as $colores) {
            // Pista 6: green está inmediatamente a la derecha de ivory
            if (!$this->inmediatamenteDerecha($colores, 'ivory', 'green')) continue;

            foreach ($this->permutaciones(['Englishman', 'Spaniard', 'Ukrainian', 'Norwegian', 'Japanese']) as $naciones) {
                // Pista 10: el noruego vive en la primera casa
                if ($naciones[0] !== 'Norwegian') continue;
                // Pista 2: el inglés vive en la casa roja
                if (!$this->mismasCasa($colores, 'red', $naciones, 'Englishman')) continue;
                // Pista 15: el noruego vive al lado de la casa azul
                if (!$this->sonAdyacentes($naciones, 'Norwegian', $colores, 'blue')) continue;

                foreach ($this->permutaciones(['coffee', 'tea', 'milk', 'orange juice', 'water']) as $bebidas) {
                    // Pista 9: la casa del medio toma leche
                    if ($bebidas[2] !== 'milk') continue;
                    // Pista 4: la casa verde toma café
                    if (!$this->mismasCasa($colores, 'green', $bebidas, 'coffee')) continue;
                    // Pista 5: el ucraniano toma té
                    if (!$this->mismasCasa($naciones, 'Ukrainian', $bebidas, 'tea')) continue;

                    foreach ($this->permutaciones(['dancing', 'painting', 'reading', 'football', 'chess']) as $hobbies) {
                        // Pista 8: la casa amarilla tiene un pintor
                        if (!$this->mismasCasa($colores, 'yellow', $hobbies, 'painting')) continue;
                        // Pista 13: el que juega fútbol toma jugo de naranja
                        if (!$this->mismasCasa($hobbies, 'football', $bebidas, 'orange juice')) continue;
                        // Pista 14: el japonés juega ajedrez
                        if (!$this->mismasCasa($naciones, 'Japanese', $hobbies, 'chess')) continue;

                        foreach ($this->permutaciones(['dog', 'snail', 'fox', 'horse', 'zebra']) as $mascotas) {
                            // Pista 3: el español tiene un perro
                            if (!$this->mismasCasa($naciones, 'Spaniard', $mascotas, 'dog')) continue;
                            // Pista 7: el dueño del caracol baila
                            if (!$this->mismasCasa($mascotas, 'snail', $hobbies, 'dancing')) continue;
                            // Pista 11: el lector vive al lado del dueño del zorro
                            if (!$this->sonAdyacentes($hobbies, 'reading', $mascotas, 'fox')) continue;
                            // Pista 12: el pintor vive al lado del dueño del caballo
                            if (!$this->sonAdyacentes($hobbies, 'painting', $mascotas, 'horse')) continue;

                            return [
                                'nacionalidades' => $naciones,
                                'bebidas'        => $bebidas,
                                'mascotas'       => $mascotas,
                            ];
                        }
                    }
                }
            }
        }

        throw new \RuntimeException('No se encontró solución');
    }

    // Los dos valores están en la misma posición (misma casa)
    private function mismasCasa(array $a, string $valA, array $b, string $valB): bool
    {
        return array_search($valA, $a) === array_search($valB, $b);
    }

    // Los dos valores están en casas contiguas (diferencia de posición = 1)
    private function sonAdyacentes(array $a, string $valA, array $b, string $valB): bool
    {
        return abs(array_search($valA, $a) - array_search($valB, $b)) === 1;
    }

    // $derecha está en la posición inmediatamente siguiente a $izquierda
    private function inmediatamenteDerecha(array $arr, string $izquierda, string $derecha): bool
    {
        return array_search($derecha, $arr) - array_search($izquierda, $arr) === 1;
    }

    private function permutaciones(array $elementos): array
    {
        if (count($elementos) <= 1) return [$elementos];

        $resultado = [];
        foreach ($elementos as $i => $elemento) {
            $resto = array_values(array_filter($elementos, fn($_, $j) => $j !== $i, ARRAY_FILTER_USE_BOTH));
            foreach ($this->permutaciones($resto) as $permutacion) {
                $resultado[] = [$elemento, ...$permutacion];
            }
        }
        return $resultado;
    }
}


// [
//     [Norwegian,    yellow,    Mascota,     Bebida,       painter]    // Primera casa
//     [Nacionalidad, blue,      Horse,       Bebida,       Hobby]      // Segunda casa
//     [Nacionalidad, colorDeCasa, Mascota,     milk,         Hobby]      // casa del medio
//     [Nacionalidad, colorDeCasa, Mascota,     Bebida,       Hobby]    // casa del medio
//     [Nacionalidad, colorDeCasa, Mascota,     Bebida,       Hobby]    // casa del medio

//     [Spaniard,     colorDeCasa, dog,         Bebida,     Hobby]
//     [Englishman, red,         Mascota,     Bebida,     Hobby]
//     [Ukrainian,    colorDeCasa, Mascota,     tea,        Hobby]


// son contiguos
//     [Nacionalidad, ivory , Mascota, Bebida, Hobby]
//     [Nacionalidad, green, Mascota, coffee, Hobby]


//     [Nacionalidad, colorDeCasa, snail, drinks, dancing]

// contiguos
//     [Nacionalidad, colorDeCasa, Mascota, drinks, reading]
//     [Nacionalidad, colorDeCasa, fox, drinks, Hobby]
// ]

//     [Nacionalidad, colorDeCasa, Mascota, orange juice, football]
//     [Japanese, colorDeCasa, Mascota, drinks, chess]

// the second house is blue


// Categoría Opción 1 Opción 2 Opción 3 Opción 4 Opción 5
// Casa Casa 1 Casa 2 Casa 3 Casa 4 Casa 5
// Color Red Green Ivory Yellow Blue
// Nacionalidad Englishman Spaniard Ukrainian Norwegian Japanese
// Mascota Dog Snail Fox Horse Zebra
// Bebida Coffee Tea Milk Orange juice Water
// Actividad Dancing Painting Reading Football Chess

// https://www.youtube.com/watch?v=nZb637zKX4E
