<?php

namespace App\Libraries;

use App\Libraries\Twig\TwigFunction;
use App\Libraries\Twig\TwigGlobal;
use App\Libraries\Twig\TwigLoader;
use Twig\Environment;

class TwigLibrarie
{
    public static function create(): Environment
    {
        $loader = new TwigLoader(\APPPATH . 'Templates');

        $twig = new Environment($loader, [
            'cache' => \WRITEPATH . 'cache/twig',
            'debug' => \ENVIRONMENT !== 'production',
            'auto_reload' => \ENVIRONMENT !== 'production',
        ]);

        TwigFunction::register($twig);
        TwigGlobal::register($twig);

        return $twig;
    }
}
