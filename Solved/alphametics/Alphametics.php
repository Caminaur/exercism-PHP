<?php

declare(strict_types=1);

class Alphametics
{
    private array $letras;        // letras ordenadas de mayor a menor impacto
    private array $coeficientes;  // cuánto "pesa" cada letra en la ecuación
    private array $minimoDigito;  // 1 si la letra abre una palabra (no puede ser 0), si no 0

    public function solve(string $puzzle): ?array
    {
        // Separar "SEND + MORE" de "MONEY"
        [$izquierda, $derecha] = preg_split('/\s*==\s*/', $puzzle);
        $resultado = trim($derecha);
        $sumandos  = preg_split('/\s*\+\s*/', trim($izquierda));

        // Calcular el coeficiente neto de cada letra.
        // La idea: en vez de evaluar SEND + MORE - MONEY para cada intento,
        // lo convertimos en una suma lineal: 1000·S + 91·E - 90·N + ... = 0
        // Los sumandos suman positivo, el resultado resta.
        $coeficientes = [];

        foreach ($sumandos as $palabra) {
            $longitud = strlen($palabra);
            foreach (str_split($palabra) as $pos => $letra) {
                $coeficientes[$letra] = ($coeficientes[$letra] ?? 0) + 10 ** ($longitud - 1 - $pos);
            }
        }

        $longitud = strlen($resultado);
        foreach (str_split($resultado) as $pos => $letra) {
            $coeficientes[$letra] = ($coeficientes[$letra] ?? 0) - 10 ** ($longitud - 1 - $pos);
        }

        // Marcar qué letras no pueden ser 0 (las que abren una palabra)
        $noPuedenSerCero = [];
        foreach ([...$sumandos, $resultado] as $palabra) {
            $noPuedenSerCero[$palabra[0]] = true;
        }

        $this->minimoDigito = [];
        foreach (array_keys($coeficientes) as $letra) {
            $this->minimoDigito[$letra] = isset($noPuedenSerCero[$letra]) ? 1 : 0;
        }

        // Ordenar las letras por peso absoluto descendente.
        // Así asignamos primero las letras que más afectan la suma,
        // y podemos descartar ramas imposibles lo antes posible.
        uasort($coeficientes, fn($a, $b) => abs($b) <=> abs($a));

        $this->letras       = array_keys($coeficientes);
        $this->coeficientes = array_values($coeficientes);

        return $this->depthFirstSearch(0, [], 0, 0);
    }

    private function depthFirstSearch(int $idx, array $asignados, int $digitosUsados, int $sumaActual): ?array
    {
        // Si asignamos todas las letras, verificamos si la ecuación se cumple
        if ($idx === count($this->letras)) {
            return $sumaActual === 0
                ? array_combine($this->letras, $asignados)
                : null;
        }

        $letra       = $this->letras[$idx];
        $coeficiente = $this->coeficientes[$idx];

        for ($digito = $this->minimoDigito[$letra]; $digito <= 9; $digito++) {

            // Saltar dígitos ya usados 
            if ($digitosUsados & (1 << $digito)) continue;

            $nuevaSuma   = $sumaActual + $coeficiente * $digito;
            $nuevosMask  = $digitosUsados | (1 << $digito);

            // Poda: ¿pueden las letras restantes llevar la suma a 0?
            // Calculamos el mejor y peor caso posible para las letras que faltan.
            // Si el 0 queda fuera de ese rango, esta rama no tiene solución.
            if ($idx + 1 < count($this->letras)) {
                $maximoPosible = 0;
                $minimoPosible = 0;

                for ($j = $idx + 1; $j < count($this->letras); $j++) {
                    $c = $this->coeficientes[$j];
                    if ($c > 0) {
                        $maximoPosible += $c * 9; // mejor caso: dígito más grande
                        $minimoPosible += $c * 0; // peor caso:  dígito más chico
                    } else {
                        $maximoPosible += $c * 0; // mejor caso: dígito más chico (coef negativo)
                        $minimoPosible += $c * 9; // peor caso:  dígito más grande
                    }
                }

                $imposible = $nuevaSuma + $maximoPosible < 0
                    || $nuevaSuma + $minimoPosible > 0;

                if ($imposible) continue;
            }

            $resultado = $this->depthFirstSearch($idx + 1, [...$asignados, $digito], $nuevosMask, $nuevaSuma);
            if ($resultado !== null) return $resultado;
        }

        return null;
    }
}
