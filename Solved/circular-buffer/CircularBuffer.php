<?php

declare(strict_types=1);
class CircularBuffer
{
    private array $elementos;  // Cola dinámica; crece y encoge con cada write/read
    private int $capacidad;    // Límite máximo de elementos permitidos

    public function __construct(int $capacidad)
    {
        $this->capacidad = $capacidad;
        $this->elementos = [];
    }

    /**
     * Lee y elimina el elemento más antiguo (FIFO).
     * array_shift() devuelve el primero y re-indexa el resto — O(n).
     */
    public function read(): mixed
    {
        if (empty($this->elementos)) {
            throw new BufferEmptyError();
        }

        return array_shift($this->elementos);
    }

    /**
     * Agrega un elemento al final de la cola.
     * Lanza BufferFullError si ya se alcanzó la capacidad máxima.
     */
    public function write(mixed $item): void
    {
        if (count($this->elementos) === $this->capacidad) {
            throw new BufferFullError($this->capacidad);
        }

        $this->elementos[] = $item;
    }

    /**
     * Vacía el buffer reemplazando el array por uno nuevo vacío.
     */
    public function clear(): void
    {
        $this->elementos = [];
    }

    /**
     * Escribe aunque el buffer esté lleno.
     * Si está lleno, descarta el elemento más antiguo antes de agregar el nuevo.
     */
    public function forceWrite(mixed $item): void
    {
        if (count($this->elementos) === $this->capacidad) {
            array_shift($this->elementos);  // Elimina el más antiguo
        }

        $this->elementos[] = $item;
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
