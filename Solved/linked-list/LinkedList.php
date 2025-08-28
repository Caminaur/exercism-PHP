<?php

declare(strict_types=1);

class Node
{
    public int $value;
    public ?Node $prev = null;
    public ?Node $next = null;

    public function __construct(int $data)
    {
        $this->value = $data;
    }
}

class LinkedList
{
    public ?Node $head = null;
    public ?Node $tail = null;

    /**
     * Adds a Station to the end
     * @param int $station
     *
     */
    public function push(int $station): void
    {
        $node = new Node($station);

        // first node
        if ($this->tail === null) {
            $this->tail = $node;
            $this->head = $node;
        } else {
            $node->prev = $this->tail; // we set the previos node as the tail of the current one
            $this->tail->next = $node; //  we set the tail node->next as the current node
            $this->tail = $node; // we set the current tail as the node
        }
    }

    /**
     * Remove a Station from the start and returns it's value
     * @return int|null
     */
    public function shift(): int|null
    {
        $value = $this->head->value;

        $this->head = $this->head->next;
        if ($this->head === null) {
            // we go back to the default values
            $this->tail = null;
        } else {
            $this->head->prev = null;
        }
        return $value;
    }


    /**
     * Remove Station from the end and returns it's value
     * @return int|null
     */
    public function pop(): int|null
    {
        $value = $this->tail->value;
        $this->tail = $this->tail->prev;

        if ($this->tail === null) {
            // list became empty
            $this->head = null;
        } else {
            $this->tail->next = null;
        }

        return $value;
    }

    /**
     * Adds Station to the start of the Linked List
     * @param int $value
     */
    public function unshift(int $value): void
    {
        $node = new Node($value);

        if ($this->head === null) {
            // empty list
            $this->tail = $node;
            $this->head = $node;
        } else {
            $node->next = $this->head;
            $this->head->prev = $node;
            $this->head = $node;
        }
    }
}
