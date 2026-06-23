<?php

namespace App\Services;

use App\Libraries\TwigLibrarie;
use Twig\Environment;

class TwigService
{
    public static function create(): Environment
    {
        return TwigLibrarie::create();
    }
}
