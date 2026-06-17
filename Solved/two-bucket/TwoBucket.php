<?php

declare(strict_types=1);

/**
 * El objetivo es llegar exactamente a una cantidad deseada de agua en alguno
 * de los dos cubos, realizando la menor cantidad de acciones posibles.
 */
class TwoBucket
{
    /**
     * Encuentra la secuencia mínima de acciones para alcanzar el objetivo.
     *
     * @param int    $capacidadCuboUno  Capacidad máxima del cubo uno (en litros)
     * @param int    $capacidadCuboDos  Capacidad máxima del cubo dos (en litros)
     * @param int    $objetivo          Cantidad exacta de litros que queremos conseguir
     * @param string $cuboInicial       Cubo con el que empezamos ('one' o 'two')
     */
    public function solve(int $capacidadCuboUno, int $capacidadCuboDos, int $objetivo, string $cuboInicial): Solution
    {
        // Si el objetivo supera la capacidad de ambos cubos, es imposible alcanzarlo
        if ($objetivo > $capacidadCuboUno && $objetivo > $capacidadCuboDos) {
            throw new Exception("El objetivo es mayor que ambos cubos");
        }

        // Estado inicial: llenamos el cubo de inicio y dejamos el otro completamente vacío
        if ($cuboInicial === 'one') {
            $litrosInicialesCuboUno = $capacidadCuboUno;
            $litrosInicialesCuboDos = 0;
        } else {
            $litrosInicialesCuboUno = 0;
            $litrosInicialesCuboDos = $capacidadCuboDos;
        }

        // Verificamos si ya alcanzamos el objetivo con la acción inicial 
        if ($litrosInicialesCuboUno === $objetivo) {
            return new Solution(1, 'one', $litrosInicialesCuboDos);
        }
        if ($litrosInicialesCuboDos === $objetivo) {
            return new Solution(1, 'two', $litrosInicialesCuboUno);
        }

        // Tabla de estados visitados para evitar procesar el mismo estado dos veces (y entrar en ciclos)
        // La clave tiene el formato "litrosCuboUno,litrosCuboDos"
        $estadosVisitados = ["$litrosInicialesCuboUno,$litrosInicialesCuboDos" => true];

        // Cola BFS: cada elemento guarda [litros en cubo 1, litros en cubo 2, acciones realizadas hasta aquí]
        // BFS garantiza que la primera solución encontrada usa el mínimo de acciones
        $queue = [[$litrosInicialesCuboUno, $litrosInicialesCuboDos, 1]];

        while (!empty($queue)) {
            // Sacamos el primer estado de la cola (orden FIFO)
            [$litrosCuboUno, $litrosCuboDos, $accionesRealizadas] = array_shift($queue);

            // Calculamos cuánta agua se puede verter entre cubos sin desbordarse ni exceder capacidades
            $aguaDisponibleParaVerterDe1a2 = min($litrosCuboUno, $capacidadCuboDos - $litrosCuboDos);
            $aguaDisponibleParaVerterDe2a1 = min($litrosCuboDos, $capacidadCuboUno - $litrosCuboUno);

            // Posibles movimientos:
            // 1. Llenar 1
            // 2. Llenar 2
            // 3. Vaciar 1
            // 4. Vaciar 2
            // 5. Verter del 1 al 2 (hasta que uno quede vacío o el otro lleno)
            // 6. Verter del 2 al 1 (hasta que uno quede vacío o el otro lleno)
            $estadosCandidatos = [
                [$capacidadCuboUno, $litrosCuboDos],
                [$litrosCuboUno, $capacidadCuboDos],
                [0, $litrosCuboDos],
                [$litrosCuboUno, 0],
                [$litrosCuboUno - $aguaDisponibleParaVerterDe1a2, $litrosCuboDos + $aguaDisponibleParaVerterDe1a2],
                [$litrosCuboUno + $aguaDisponibleParaVerterDe2a1, $litrosCuboDos - $aguaDisponibleParaVerterDe2a1],
            ];

            foreach ($estadosCandidatos as [$nuevoLitrosCuboUno, $nuevoLitrosCuboDos]) {
                // Estado prohibido por las reglas del problema:
                if ($cuboInicial === 'one' && $nuevoLitrosCuboUno === 0 && $nuevoLitrosCuboDos === $capacidadCuboDos) continue;
                if ($cuboInicial === 'two' && $nuevoLitrosCuboUno === $capacidadCuboUno && $nuevoLitrosCuboDos === 0) continue;

                // Si ya exploramos este estado antes, lo ignoramos para no repetir trabajo
                $claveEstado = "$nuevoLitrosCuboUno,$nuevoLitrosCuboDos";
                if (isset($estadosVisitados[$claveEstado])) continue;
                $estadosVisitados[$claveEstado] = true;

                // Esta acción cuenta como un paso más
                $accionesTotales = $accionesRealizadas + 1;

                // Comprobamos si alguno de los cubos alcanzó exactamente el objetivo
                if ($nuevoLitrosCuboUno === $objetivo) {
                    return new Solution($accionesTotales, 'one', $nuevoLitrosCuboDos);
                }
                if ($nuevoLitrosCuboDos === $objetivo) {
                    return new Solution($accionesTotales, 'two', $nuevoLitrosCuboUno);
                }

                // El objetivo aún no se alcanzó; añadimos este estado a la cola para seguir explorando
                $queue[] = [$nuevoLitrosCuboUno, $nuevoLitrosCuboDos, $accionesTotales];
            }
        }

        // Si la cola se vació sin encontrar solución, el problema no tiene respuesta posible
        throw new Exception("No hay solución posible");
    }
}

/**
 * Representa el resultado de la solución encontrada.
 */
class Solution
{
    public function __construct(
        public int $numberOfActions,                    // Total de acciones necesarias para llegar al objetivo
        public string $nameOfBucketWithDesiredLiters,   // Cubo que contiene los litros deseados al finalizar ('one' o 'two')
        public int $litersLeftInOtherBucket             // Litros que quedan en el otro cubo al finalizar
    ) {}
}
