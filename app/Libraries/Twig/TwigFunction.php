<?php

namespace App\Libraries\Twig;

use Twig\TwigFunction as TwigFunctionAlias;

class TwigFunction
{
    public static function register(\Twig\Environment $twig): void
    {
        $twig->addFunction(new TwigFunctionAlias('base_url', static fn(string $path): string => base_url($path)));

        $twig->addFunction(new TwigFunctionAlias('route_to', static function (string $name, mixed ...$params): string {
            return route_to($name, ...$params);
        }));

        $twig->addFunction(new TwigFunctionAlias('old', static function (string $key, mixed $default = null): mixed {
            return old($key, $default);
        }));
    }
}
