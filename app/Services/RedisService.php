<?php

namespace App\Services;

use Predis\Client;
use Config\Queue;

class RedisService
{
    public static function create(): Client
    {
        $config = config('Queue');

        return new Client($config->predis);
    }
}
