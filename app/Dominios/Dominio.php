<?php

namespace App\Dominios;

abstract class Dominio
{
    abstract public static function lista(): array;

    public static function obter(array $codigos): array
    {
        return array_intersect_key(
            static::lista(),
            array_flip($codigos)
        );
    }

    public static function item(string $codigo): ?array
    {
        return static::lista()[$codigo] ?? null;
    }

    public static function descricao(string $codigo): string
    {
        return static::item($codigo)['descricao'] ?? '';
    }

    public static function cor(string $codigo): string
    {
        return static::item($codigo)['cor'] ?? 'secondary';
    }

    public static function icone(string $codigo): string
    {
        return static::item($codigo)['icone'] ?? '';
    }

    public static function options(): array
    {
        return array_column(
            static::lista(),
            'descricao',
            'codigo'
        );
    }
}