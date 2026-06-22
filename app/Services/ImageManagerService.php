<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageManagerService
{
    public static function create(): ImageManager
    {
        return new ImageManager(new Driver());
    }
}
