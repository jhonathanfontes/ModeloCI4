<?php

namespace App\Libraries\Twig;

use App\Helpers\Formatacao;
use App\Helpers\Mascara;
use Twig\TwigFunction as TwigFunctionAlias;

class TwigFunction
{
    public static function register(\Twig\Environment $twig): void
    {
        $twig->addFunction(new TwigFunctionAlias('base_url', static fn (string $path): string => base_url($path)));

        $twig->addFunction(new TwigFunctionAlias('route_to', static function (string $name, mixed ...$params): string {
            return route_to($name, ...$params);
        }));

        $twig->addFunction(new TwigFunctionAlias('old', static function (string $key, mixed $default = null): mixed {
            return old($key, $default);
        }));

        self::registerMascaras($twig);
        self::registerFormatacoes($twig);
    }

    private static function registerMascaras(\Twig\Environment $twig): void
    {
        $twig->addFunction(new TwigFunctionAlias('cpf', static fn (string $v): string => Mascara::cpf($v)));
        $twig->addFunction(new TwigFunctionAlias('cnpj', static fn (string $v): string => Mascara::cnpj($v)));
        $twig->addFunction(new TwigFunctionAlias('cep', static fn (string $v): string => Mascara::cep($v)));
        $twig->addFunction(new TwigFunctionAlias('telefone', static fn (string $v): string => Mascara::telefone($v)));
        $twig->addFunction(new TwigFunctionAlias('celular', static fn (string $v): string => Mascara::celular($v)));
        $twig->addFunction(new TwigFunctionAlias('data', static fn (string $v): string => Mascara::data($v)));
        $twig->addFunction(new TwigFunctionAlias('cnpjCpf', static fn (string $v): string => Mascara::cnpjCpf($v)));
        $twig->addFunction(new TwigFunctionAlias('placa', static fn (string $v): string => Mascara::placa($v)));
        $twig->addFunction(new TwigFunctionAlias('removeMascara', static fn (string $v): string => Mascara::remove($v)));
    }

    private static function registerFormatacoes(\Twig\Environment $twig): void
    {
        $twig->addFunction(new TwigFunctionAlias('moeda', static fn ($v, bool $s = true): string => Formatacao::moeda($v, $s)));
        $twig->addFunction(new TwigFunctionAlias('numeroFormat', static fn ($v, int $d = 2): string => Formatacao::numero($v, $d)));
        $twig->addFunction(new TwigFunctionAlias('percentual', static fn ($v, int $d = 2): string => Formatacao::percentual($v, $d)));
        $twig->addFunction(new TwigFunctionAlias('bytes', static fn (int $b, int $d = 2): string => Formatacao::bytes($b, $d)));
        $twig->addFunction(new TwigFunctionAlias('segundos', static fn (int $s): string => Formatacao::segundos($s)));
        $twig->addFunction(new TwigFunctionAlias('dataHora', static fn (string $f = 'd/m/Y H:i:s', ?string $d = null): string => Formatacao::dataHora($f, $d)));
        $twig->addFunction(new TwigFunctionAlias('dataBR', static fn (?string $d = null): string => Formatacao::dataBR($d)));
        $twig->addFunction(new TwigFunctionAlias('dataExtenso', static fn (?string $d = null): string => Formatacao::dataExtenso($d)));
        $twig->addFunction(new TwigFunctionAlias('limitarTexto', static fn (string $t, int $l = 100, string $e = '...'): string => Formatacao::limitarTexto($t, $l, $e)));
        $twig->addFunction(new TwigFunctionAlias('slug', static fn (string $t, string $sep = '-'): string => Formatacao::slug($t, $sep)));
        $twig->addFunction(new TwigFunctionAlias('somenteNumeros', static fn (string $v): string => Formatacao::somenteNumeros($v)));
    }
}
