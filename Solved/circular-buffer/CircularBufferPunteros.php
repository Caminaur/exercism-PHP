<?php

declare(strict_types=1);

/**
 * Buffer circular de capacidad fija usando un array fijo con punteros cabeza/cola.
 * Todas las operaciones son O(1) — no se mueven elementos, solo avanzan los punteros.
 */
class CircularBuffer
{
    private array $buffer;   // Array de tamaño fijo; las posiciones se reutilizan en círculo
    private int $capacidad;  // Capacidad máxima del buffer
    private int $cabeza;     // Índice del próximo elemento a leer (el más antiguo)
    private int $cola;       // Índice de la próxima posición libre para escribir
    private int $cantidad;   // Número de elementos actualmente almacenados

    public function __construct(int $capacidad)
    {
        $this->capacidad = $capacidad;
        $this->buffer    = array_fill(0, $capacidad, null);
        $this->cabeza    = 0;
        $this->cola      = 0;
        $this->cantidad  = 0;
    }

    /**
     * Lee y elimina el elemento más antiguo del buffer (orden FIFO).
     * Lanza BufferEmptyError si el buffer está vacío.
     */
    public function read(): mixed
    {
        if ($this->cantidad === 0) {
            throw new BufferEmptyError();
        }

        $elementoLeido = $this->buffer[$this->cabeza];

        // Avanzamos la cabeza en círculo: cuando llega al final, vuelve al índice 0
        $this->cabeza = ($this->cabeza + 1) % $this->capacidad;
        $this->cantidad--;

        return $elementoLeido;
    }

    /**
     * Escribe un nuevo elemento al final del buffer.
     * Lanza BufferFullError si el buffer está lleno.
     */
    public function write(mixed $item): void
    {
        if ($this->cantidad === $this->capacidad) {
            throw new BufferFullError($this->capacidad);
        }

        $this->buffer[$this->cola] = $item;

        // Avanzamos la cola en círculo
        $this->cola = ($this->cola + 1) % $this->capacidad;
        $this->cantidad++;
    }

    /**
     * Vacía el buffer completamente.
     * Solo reseteamos los punteros; no hace falta limpiar el array.
     */
    public function clear(): void
    {
        $this->cabeza   = 0;
        $this->cola     = 0;
        $this->cantidad = 0;
    }

    /**
     * Escribe un elemento incluso si el buffer está lleno.
     * Si está lleno, descarta el elemento más antiguo (avanza la cabeza) antes de escribir.
     */
    public function forceWrite(mixed $item): void
    {
        if ($this->cantidad === $this->capacidad) {
            // Descartamos el elemento más antiguo avanzando la cabeza sin leerlo
            $this->cabeza = ($this->cabeza + 1) % $this->capacidad;
            $this->cantidad--;
        }

        $this->write($item);
    }
}

class BufferFullError extends \RuntimeException
{
    public function __construct(int $capacidadMaxima)
    {
        parent::__construct("No se puede escribir: el buffer está lleno (capacidad máxima: {$capacidadMaxima})");
    }
}

class BufferEmptyError extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("No se puede leer: el buffer está vacío");
    }
}
