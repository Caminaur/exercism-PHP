<?php

declare(strict_types=1);

function score(float $leg1, float $leg2): int
{
    $hypotenuse = sqrt((pow($leg1, 2) + pow($leg2, 2)));
    if ($hypotenuse <= 1) {
        return 10;
    } elseif ($hypotenuse >= 1 && $hypotenuse <= 5) {
        return 5;
    } elseif ($hypotenuse >= 5 && $hypotenuse <= 10) {
        return 1;
    } else {
        return 0;
    }
}
