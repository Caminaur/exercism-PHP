<?php

declare(strict_types=1);

class FoodChain
{
    public function verse(int $verseNumber): array
    {
        throw new \BadMethodCallException(sprintf('Implement the %s method', __FUNCTION__));
    }

    public function verses(int $start, int $end): array
    {
        throw new \BadMethodCallException(sprintf('Implement the %s method', __FUNCTION__));
    }

    public function song(): array
    {
        throw new \BadMethodCallException(sprintf('Implement the %s method', __FUNCTION__));
    }
}
