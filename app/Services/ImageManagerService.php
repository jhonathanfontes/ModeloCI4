<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageManagerService
{
    public static function create(): ImageManager
    {
        return new ImageManager(new Driver());
    }
}
