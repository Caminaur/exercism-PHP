# Alphametics — Explicación del algoritmo paso a paso

Usaremos este puzzle como ejemplo a lo largo de toda la explicación:

```
SEND + MORE == MONEY
```

La solución correcta es: `S=9, E=5, N=6, D=7, M=1, O=0, R=8, Y=2`

---

## ¿Qué es Alphametics?

Cada letra representa un dígito único (0–9). El objetivo es encontrar qué dígito le corresponde a cada letra para que la ecuación sea verdadera. Las restricciones son:
- Cada letra tiene un dígito diferente.
- Ninguna palabra puede empezar con 0 (no hay "leading zeros").

---

## Paso 1 — Parsear el puzzle

```php
[$lhs, $rhs] = preg_split('/\s*==\s*/', $puzzle);
$resultWord  = trim($rhs);                              // "MONEY"
$addendWords = preg_split('/\s*\+\s*/', trim($lhs));   // ["SEND", "MORE"]
```

Separamos el puzzle en:
- **Sumandos** (lado izquierdo): `["SEND", "MORE"]`
- **Resultado** (lado derecho): `"MONEY"`

---

## Paso 2 — Calcular coeficientes

Esta es la optimización clave. En vez de evaluar `SEND + MORE - MONEY` para cada combinación de dígitos, transformamos el problema en una **suma lineal**:

```
SEND  = S×1000 + E×100 + N×10 + D×1
MORE  = M×1000 + O×100 + R×10 + E×1
MONEY = M×10000 + O×1000 + N×100 + E×10 + Y×1
```

La ecuación `SEND + MORE == MONEY` es equivalente a:

```
SEND + MORE - MONEY = 0
```

Entonces agrupamos por letra:

| Letra | Contribuciones                              | Coeficiente neto |
|-------|---------------------------------------------|------------------|
| S     | +1000 (SEND)                                | **+1000**        |
| E     | +100 (SEND) + 1 (MORE) − 10 (MONEY)        | **+91**          |
| N     | +10 (SEND) − 100 (MONEY)                   | **−90**          |
| D     | +1 (SEND)                                   | **+1**           |
| M     | +1000 (MORE) − 10000 (MONEY)               | **−9000**        |
| O     | +100 (MORE) − 1000 (MONEY)                 | **−900**         |
| R     | +10 (MORE)                                  | **+10**          |
| Y     | −1 (MONEY)                                  | **−1**           |

El código que hace esto:

```php
foreach ($addendWords as $word) {
    $len = strlen($word);
    foreach (str_split($word) as $i => $letter) {
        // posición 0 = letra más significativa
        // potencia = 10^(len-1-i)
        $coefficients[$letter] = ($coefficients[$letter] ?? 0) + 10 ** ($len - 1 - $i);
    }
}
// Para el resultado, restamos en vez de sumar
foreach (str_split($resultWord) as $i => $letter) {
    $coefficients[$letter] = ($coefficients[$letter] ?? 0) - 10 ** ($len - 1 - $i);
}
```

Ahora la ecuación completa es simplemente:

```
1000·S + 91·E − 90·N + 1·D − 9000·M − 900·O + 10·R − 1·Y = 0
```

Evaluar esto es **8 multiplicaciones y 7 sumas**, sin importar cuántos sumandos tenga el puzzle original (el de 199 sumandos también se reduce a esto).

---

## Paso 3 — Restricción de leading zero

Las primeras letras de cada palabra no pueden ser 0:
- `S` (SEND), `M` (MORE), `M` (MONEY) → `S` y `M` no pueden ser 0.

```php
$noZero = [];
foreach ([...$addendWords, $resultWord] as $word) {
    $noZero[$word[0]] = true;  // marca la primera letra de cada palabra
}

$this->minDigit[$letter] = isset($noZero[$letter]) ? 1 : 0;
```

`$minDigit` guarda el mínimo dígito permitido para cada letra:
- `S → 1`, `M → 1`
- `E, N, D, O, R, Y → 0`

---

## Paso 4 — Ordenar por |coeficiente| descendente

```php
uasort($coefficients, fn($a, $b) => abs($b) <=> abs($a));
```

Resultado del ordenamiento:

```
M(−9000), O(−900), S(+1000), N(−90), E(+91), R(+10), D(+1), Y(−1)
```

**¿Por qué importa este orden?**

Si asignamos primero las letras con mayor coeficiente, cada decisión tiene un **impacto grande** en la suma parcial. Esto hace que el detector de imposibilidad (paso 5) pueda descartar ramas enteras del árbol mucho antes.

Ejemplo: si asignamos `M=5` (coeficiente −9000), la suma parcial salta a `−45000`. Las letras restantes con coeficientes pequeños no pueden compensar tanto, y la rama se poda inmediatamente.

---

## Paso 5 — DFS con poda por cotas (bounds pruning)

El algoritmo explora un árbol de decisiones. En cada nivel asigna un dígito a una letra:

```
Nivel 0: asignar dígito a M  (coef −9000)
Nivel 1: asignar dígito a O  (coef −900)
Nivel 2: asignar dígito a S  (coef +1000)
...
Nivel 7: asignar dígito a Y  (coef −1)
```

### Sin poda (fuerza bruta)

En el peor caso exploramos `10 × 9 × 8 × ... × 3 = 10!/2! ≈ 1.8 millones` de nodos.

### Con poda por cotas

Después de cada asignación, calculamos si todavía es **matemáticamente posible** llegar a suma = 0.

```php
$newSum = $partialSum + $coeff * $d;

$maxRem = 0;
$minRem = 0;
for ($j = $idx + 1; $j < $n; $j++) {
    $c = $this->coefficients[$j];
    if ($c > 0) {
        $maxRem += $c * 9;  // máximo aporte: coef positivo × dígito máximo (9)
        $minRem += $c * 0;  // mínimo aporte: coef positivo × dígito mínimo (0)
    } else {
        $maxRem += $c * 0;  // máximo aporte: coef negativo × dígito mínimo (0)
        $minRem += $c * 9;  // mínimo aporte: coef negativo × dígito máximo (9)
    }
}

if ($newSum + $maxRem < 0) continue;  // aunque pongamos los mejores dígitos, no llegamos a 0
if ($newSum + $minRem > 0) continue;  // aunque pongamos los peores dígitos, nos pasamos de 0
```

### Ejemplo concreto de poda

Supón que intentamos `M=5`:

```
newSum = 0 + (−9000 × 5) = −45000
```

Calculamos los cotas para las letras restantes `O, S, N, E, R, D, Y`:

```
maxRem = (−900×0) + (1000×9) + (−90×0) + (91×9) + (10×9) + (1×9) + (−1×0)
       = 0 + 9000 + 0 + 819 + 90 + 9 + 0
       = +9918

minRem = (−900×9) + (1000×0) + (−90×9) + (91×0) + (10×0) + (1×0) + (−1×9)
       = −8100 + 0 − 810 + 0 + 0 + 0 − 9
       = −8919
```

Verificamos:

```
newSum + maxRem = −45000 + 9918 = −35082  < 0  → PODA ✂️
```

Con `M=5`, aunque asignemos los mejores dígitos posibles a las demás letras, la suma nunca puede llegar a 0. Se descartan las `9 × 8 × 7 × ... = 362880` combinaciones restantes de golpe.

### Ejemplo de rama válida

Con `M=1`:

```
newSum = 0 + (−9000 × 1) = −9000

maxRem = 0 + 9000 + 0 + 819 + 90 + 9 + 0 = +9918
minRem = −8100 + 0 − 810 + 0 + 0 + 0 − 9 = −8919

newSum + maxRem = −9000 + 9918 = +918  > 0  ✓
newSum + minRem = −9000 − 8919 = −17919 < 0  ✓
```

El 0 está dentro del rango posible → seguimos explorando.

---

## Paso 6 — Bitmask para dígitos usados

```php
if ($usedMask & (1 << $d)) continue;  // ¿ya está usado el dígito d?
$newMask = $usedMask | (1 << $d);     // marcar d como usado
```

En vez de un array con `in_array()` (O(n)), usamos un entero de 10 bits. Cada bit representa un dígito:

```
bit 0 = dígito 0
bit 1 = dígito 1
...
bit 9 = dígito 9
```

Ejemplo: si ya usamos los dígitos 1, 5 y 8:

```
usedMask = 0b1000100010 = 546
           ^  ^   ^
           8  5   1
```

Comprobar si el dígito 5 está usado: `546 & (1 << 5) = 546 & 32 = 32 ≠ 0` → sí está usado.

---

## Paso 7 — Caso base: solución encontrada

Cuando hemos asignado dígitos a todas las letras (`idx === n`), simplemente verificamos que la suma de coeficientes dé exactamente 0:

```php
if ($idx === $n) {
    return $partialSum === 0
        ? array_combine($this->alphabets, $assigned)
        : null;
}
```

Si es 0, construimos el array resultado `['S' => 9, 'E' => 5, ...]` y lo devolvemos hacia arriba por toda la recursión.

---

## Flujo completo resumido

```
solve("SEND + MORE == MONEY")
│
├─ Parsear → addends: [SEND, MORE], result: MONEY
├─ Calcular coeficientes → {M:−9000, O:−900, S:+1000, N:−90, E:+91, R:+10, D:+1, Y:−1}
├─ Leading zeros → minDigit: {M:1, S:1, resto:0}
├─ Ordenar por |coef| → [M, O, S, N, E, R, D, Y]
└─ dfs(idx=0, assigned=[], usedMask=0, partialSum=0)
   │
   ├─ M=1 → partialSum=−9000 → cotas OK → dfs(idx=1...)
   │  ├─ O=0 → partialSum=−9000 → cotas OK → dfs(idx=2...)
   │  │  ├─ S=2 → partialSum=−7000 → cotas FALLA ✂️
   │  │  ├─ S=3 → partialSum=−6000 → cotas FALLA ✂️
   │  │  │  ...
   │  │  └─ S=9 → partialSum=−9000+9000=0 → cotas OK → dfs(idx=3...)
   │  │     └─ ... → solución encontrada: {S:9,E:5,N:6,D:7,M:1,O:0,R:8,Y:2}
   │  │
   │  ├─ O=2 → partialSum=−10800 → cotas FALLA ✂️
   │  └─ ...
   │
   ├─ M=2 → partialSum=−18000 → cotas FALLA ✂️
   ├─ M=3 → partialSum=−27000 → cotas FALLA ✂️
   └─ ... (todas podadas)
```

---

## ¿Por qué es tan rápido?

| Métrica             | Solución anterior       | Solución optimizada     |
|---------------------|-------------------------|-------------------------|
| Evaluación de ecuación | Suma de N palabras (eval) | 8 multiplicaciones     |
| Orden de asignación | Orden arbitrario        | Mayor impacto primero   |
| Poda                | Solo en la hoja         | En cada nodo del árbol  |
| Dígitos usados      | `in_array` O(n)         | Bitmask O(1)            |
| Tiempo (199 sumandos) | ~78 segundos          | < 0.5 segundos          |

La poda por cotas es el cambio más importante: en vez de explorar millones de hojas, descarta ramas enteras del árbol desde los primeros niveles.
