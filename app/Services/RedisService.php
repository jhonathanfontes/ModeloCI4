<?php

namespace App\Services;

use Predis\Client;

class RedisService
{
    public static function create(): Client
    {
        $config = config('Queue');

        return new Client($config->predis);
    }
}
