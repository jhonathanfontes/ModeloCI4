<?php

namespace App\Helpers;

class Uuid
{
    public static function generate(string $seed): string
    {
        $hash = md5($seed);

        return sprintf(
            '%s-%s-4%s-%s-%s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            substr($hash, 13, 3),
            dechex(hexdec(substr($hash, 16, 4)) & 0x3fff | 0x8000),
            substr($hash, 20, 12)
        );
    }
}
