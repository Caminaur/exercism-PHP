<?php

declare(strict_types=1);

class ListOps
{
    public function append(array $list1, array $list2): array
    {
        foreach ($list2 as $v) {
            $list1[] = $v;
        }
        return $list1;
    }

    public function concat(array $list1, array ...$listn): array
    {
        foreach ($listn as $arr) {
            foreach ($arr as $v) {
                $list1[] = $v;
            }
        }
        return $list1;
    }

    /**
     * @param callable(mixed $item): bool $predicate
     */
    public function filter(callable $predicate, array $list): array
    {
        $resp = [];
        foreach ($list as $item) {
            if ($predicate($item)) {
                $resp[] = $item;
            }
        }
        return $resp;
    }

    public function length(array $list): int
    {
        $length = 0;
        foreach ($list as $_) {
            $length++;
        }
        return $length;
    }

    /**
     * @param callable(mixed $item): mixed $function
     */
    public function map(callable $function, array $list): array
    {
        $resp = [];
        foreach ($list as $item) {
            $resp[] = $function($item);
        }
        return $resp;
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     */
    public function foldl(callable $function, array $list, $accumulator)
    {
        foreach ($list as $item) {
            $accumulator = $function($accumulator, $item);
        }
        return $accumulator;
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     */
    public function foldr(callable $function, array $list, $accumulator)
    {
        foreach ($this->reverse($list) as $item) {
            $accumulator = $function($accumulator, $item);
        }

        return $accumulator;
    }

    public function reverse(array $list): array
    {
        $rev = [];
        for ($i = $this->length($list) - 1; $i >= 0; $i--) {
            $rev[] = $list[$i];
        }
        return $rev;
    }
}
