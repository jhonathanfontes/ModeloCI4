<?php

namespace App\Helpers;

class Formatacao
{
    public static function moeda(float|int|string $value, bool $simbolo = true): string
    {
        $formatted = number_format((float) $value, 2, ',', '.');

        return $simbolo ? 'R$ ' . $formatted : $formatted;
    }

    public static function numero(float|int|string $value, int $decimais = 2): string
    {
        return number_format((float) $value, $decimais, ',', '.');
    }

    public static function percentual(float|int|string $value, int $decimais = 2): string
    {
        return number_format((float) $value, $decimais, ',', '.') . '%';
    }

    public static function decimal(string $value): float
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    public static function bytes(int $bytes, int $decimais = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return static::numero($bytes, $decimais) . ' ' . $units[$i];
    }

    public static function segundos(int $seconds): string
    {
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        $s = $seconds % 60;

        $parts = [];

        if ($h > 0) {
            $parts[] = sprintf('%dh', $h);
        }

        if ($m > 0) {
            $parts[] = sprintf('%dmin', $m);
        }

        if ($s > 0 || empty($parts)) {
            $parts[] = sprintf('%ds', $s);
        }

        return implode(' ', $parts);
    }

    public static function dataHora(string $format = 'd/m/Y H:i:s', ?string $date = null): string
    {
        return date($format, $date ? strtotime($date) : time());
    }

    public static function dataBR(?string $date = null): string
    {
        if ($date === null || $date === '' || $date === '0000-00-00') {
            return '';
        }

        return date('d/m/Y', strtotime($date));
    }

    public static function dataExtenso(?string $date = null): string
    {
        $months = [
            1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
            'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro',
        ];

        $timestamp = $date ? strtotime($date) : time();
        $day       = date('j', $timestamp);
        $month     = $months[(int) date('n', $timestamp)];
        $year      = date('Y', $timestamp);

        return "{$day} de {$month} de {$year}";
    }

    public static function limitarTexto(string $text, int $limit = 100, string $end = '...'): string
    {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        $truncated = mb_substr($text, 0, $limit);
        $lastSpace = mb_strrpos($truncated, ' ');

        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return $truncated . $end;
    }

    public static function slug(string $text, string $separator = '-'): string
    {
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = preg_replace('/[\s-]+/', $separator, $text);
        $text = trim($text, $separator);

        return mb_strtolower($text);
    }

    public static function somenteNumeros(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }

    public static function telefoneInternacional(string $value, string $countryCode = '55'): string
    {
        $digits = preg_replace('/\D/', '', $value);

        return '+' . $countryCode . ' ' . $digits;
    }
}
