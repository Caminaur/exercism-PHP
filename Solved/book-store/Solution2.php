<?php

declare(strict_types=1);
function total(array $items): float
{
    $totalGroups = max([1, ...array_count_values($items)]);
    $groups = array_fill(0, min(2, $totalGroups), 0);
    for ($i = 0; $i++ < count($items); sort($groups))
        $groups[0] === 5 ? $groups[] = 1 : $groups[0]++;
    $groupsPriced = array_map(fn($items) => [8, 15.2, 21.6, 25.6, 30][$items - 1] ?? 0, $groups);
    return array_sum($groupsPriced);
}
