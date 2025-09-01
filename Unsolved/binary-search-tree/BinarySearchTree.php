<?php

declare(strict_types=1);

class BinarySearchTree
{
    public ?BinarySearchTree $left;
    public ?BinarySearchTree $right;
    public int $data;

    public function __construct(int $data)
    {
        $this->data = $data;
        $this->left = NULL;
        $this->right = NULL;
    }

    public function insert(int $data): void
    {
        // go left
        if ($data <= $this->data) {
            if ($this->left === NULL) {
                $this->left = new BinarySearchTree($data);
            } else {
                $this->left->insert($data);
            }
        } else {
            if ($this->right === NULL) {
                $this->right = new BinarySearchTree($data);
            } else {
                $this->right->insert($data);
            }
        }
    }


    public function getOrderedValues(?BinarySearchTree $branch): array
    {
        if ($branch === null) {
            return [];
        }

        $t = [];

        $t = array_merge($t, $this->getOrderedValues($branch->left)); // left branch
        $t[] = $branch->data; // current node value
        $t = array_merge($t, $this->getOrderedValues($branch->right)); // right branch

        return $t;
    }

    public function getSortedData(): array
    {
        $currentNode = $this;

        return $this->getOrderedValues($currentNode);
    }
}


// same or smaller numbers go on left node
// biggers on the right