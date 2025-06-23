<?php

declare(strict_types=1);

class Strain
{
    public function keep(array $list, callable $predicate): array
    {
        $response = [];
        foreach ($list as $v) {
            if ($predicate($v)) {
                $response[] = $v;
            }
        }
        return $response;
    }

    public function discard(array $list, callable $predicate): array
    {
        $response = [];
        foreach ($list as $v) {
            if (!$predicate($v)) {
                $response[] = $v;
            }
        }
        return $response;
    }
}
