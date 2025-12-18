<?php

declare(strict_types=1);

class ListOps
{
    public function append(array $list1, array $list2): array
    {
        $resp = [];
        foreach ($list1 as $v) {
            $resp[] = $v;
        }
        foreach ($list2 as $v) {
            $resp[] = $v;
        }
        return $resp;
    }

    public function concat(array $list1, array ...$listn): array
    {
        $resp = [];
        foreach ($list1 as $v) {
            $resp[] = $v;
        }
        foreach ($listn as $arr) {
            foreach ($arr as $v) {
                $resp[] = $v;
            }
        }
        return $resp;
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

        foreach ($list as $value) {
            $tmp = [$value];
            foreach ($rev as $v) {
                $tmp[] = $v;
            }
            $rev = $tmp;
        }
        return $rev;
    }
}
