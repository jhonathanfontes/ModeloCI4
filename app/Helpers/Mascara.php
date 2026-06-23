<?php

namespace App\Helpers;

class Mascara
{
    public static function cpf(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            str_pad($digits, 11, '0', STR_PAD_LEFT)
        );
    }

    public static function cnpj(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        return preg_replace(
            '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
            '$1.$2.$3/$4-$5',
            str_pad($digits, 14, '0', STR_PAD_LEFT)
        );
    }

    public static function cep(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        return preg_replace(
            '/(\d{5})(\d{3})/',
            '$1-$2',
            str_pad($digits, 8, '0', STR_PAD_LEFT)
        );
    }

    public static function telefone(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) === 8) {
            return preg_replace('/(\d{4})(\d{4})/', '$1-$2', $digits);
        }

        if (strlen($digits) === 9) {
            return preg_replace('/(\d{5})(\d{4})/', '$1-$2', $digits);
        }

        if (strlen($digits) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
        }

        if (strlen($digits) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $digits);
        }

        return $digits;
    }

    public static function celular(string $value): string
    {
        return static::telefone($value);
    }

    public static function data(string $value): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            $parts = explode(' ', $value);
            $date = explode('-', $parts[0]);
            $time = $parts[1] ?? '';

            return ($date[2] ?? '') . '/' . $date[1] . '/' . $date[0] . ($time ? ' ' . $time : '');
        }

        return $value;
    }

    public static function cnpjCpf(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) <= 11) {
            return static::cpf($digits);
        }

        return static::cnpj($digits);
    }

    public static function dinheiro(float|int|string $value, int $decimais = 2): string
    {
        return 'R$ ' . number_format((float) $value, $decimais, ',', '.');
    }

    public static function placa(string $value): string
    {
        $value = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $value));

        if (strlen($value) === 7) {
            return preg_replace('/([A-Z]{3})(\d{4})/', '$1-$2', $value);
        }

        return preg_replace('/([A-Z]{3})(\d{1})([A-Z0-9]{1})(\d{2})/', '$1$2$3$4', $value);
    }

    public static function remove(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }
}
