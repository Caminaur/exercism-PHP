<?php

declare(strict_types=1);

function maskify(string $cc): string
{
    if (strlen($cc) <= 6) return $cc;
    return preg_replace('/(?!^)\d(?=(?:\D*\d){4})/', '#', $cc);
}
