<?php

declare(strict_types=1);

function score(float $leg1, float $leg2): int
{
    $hypotenuse = hypot($leg1, $leg2);
    if ($hypotenuse <= 1) return 10;
    if ($hypotenuse <= 5) return 5;
    if ($hypotenuse <= 10) return 1;
    return 0;
}
