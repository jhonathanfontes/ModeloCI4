<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig
{
    /**
     * Secret Key for JWT. Change this to a random string.
     */
    public string $secretKey = 'your_secret_key_here';

    /**
     * Algorithm used for JWT.
     */
    public string $algorithm = 'HS256';

    /**
     * Token expiration time in seconds (e.g., 3600 for 1 hour).
     */
    public int $expiresIn = 3600;
}
