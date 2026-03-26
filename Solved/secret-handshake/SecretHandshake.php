<?php

declare(strict_types=1);

class SecretHandshake
{
    public function commands(int $handshake): array
    {
        $binary = array_reverse(str_split((string)decbin($handshake)));
        $secretHandshake = [];
        $flip = false;

        for ($i = 0; $i < count($binary); $i++) {
            $number = $binary[$i];
            if ($number === '0') {
                continue;
            }
            if ($i == 4) {
                $flip = true;
                break;
            }
            $secretHandshake[] = match ($i) {
                0 => 'wink',
                1 => 'double blink',
                2 => 'close your eyes',
                3 => 'jump',
            };
        }


        if ($flip) {
            return array_reverse($secretHandshake);
        }
        return $secretHandshake;
    }
}
