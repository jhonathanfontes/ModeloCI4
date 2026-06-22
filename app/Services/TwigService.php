<?php

namespace App\Services;

use Twig\Environment;
use App\Libraries\TwigLibrarie;

class TwigService
{
    public static function create(): Environment
    {
        return TwigLibrarie::create();
    }
}
