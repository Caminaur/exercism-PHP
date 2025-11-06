<?php

declare(strict_types=1);

class MicroBlog
{
    public function truncate(string $text): string
    {
        mb_internal_encoding('UTF-8');
        return mb_substr($text, 0, 5);
    }
}
