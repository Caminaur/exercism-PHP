<?php

declare(strict_types=1);

class Strain
{
    public function keep(array $list, callable $predicate): array
    {
        return $this->filterByPredicate($list, $predicate, true);
    }

    public function discard(array $list, callable $predicate): array
    {
        return $this->filterByPredicate($list, $predicate, false);
    }

    private function filterByPredicate(array $list, callable $predicate, bool $shouldMatch)
    {
        $response = [];
        foreach ($list as $v) {
            if ($predicate($v) === $shouldMatch) {
                $response[] = $v;
            }
        }
        return $response;
    }
}
