<?php

declare(strict_types=1);

class Sublist
{
    public function compare(array $listOne, array $listTwo): string
    {
        if ($listOne === $listTwo) {
            return "EQUAL";
        }

        if ($this->isSublist($listTwo, $listOne)) {
            return "SUPERLIST";
        }

        if ($this->isSublist($listOne, $listTwo)) {
            return "SUBLIST";
        }

        return "UNEQUAL";
    }

    private function isSublist(array $a, array $b): bool
    {

        // a [1,2] 1
        // b [2,1,3,1,2] 2
        $m = count($a);
        $n = count($b);

        if ($m === 0) return true;
        if ($m > $n)  return false;

        $ai = 0;
        $bi = 0;

        while ($bi < $n) {

            if ($a[$ai] === $b[$bi]) {
                $ai++;
                $bi++;
                if ($ai === $m) {
                    return true;
                }
            } else {
                // hubo coincidencias pero se rompio
                if ($ai > 0) {
                    $bi = $bi - $ai + 1;
                    $ai = 0;
                } else {
                    $bi++;
                }
            }
        }
        return false;
    }
}
