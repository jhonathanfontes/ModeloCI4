<?php

namespace App\Dominios;

abstract class Dominio
{
    abstract public static function lista(): array;

    abstract public static function modulo(): string;

    public static function dadosBanco(): array
    {
        $registros = [];
        foreach (static::lista() as $codigo => $item) {
            $registros[] = [
                'UUID' => \App\Helpers\Uuid::generate(static::modulo() . '_' . $codigo),
                'MODULO' => static::modulo(),
                'CODIGO' => $codigo,
                'DESCRICAO' => $item['descricao'],
                'COR' => $item['cor'] ?? null,
                'ICONE' => $item['icone'] ?? null,
                'FINALIZADO' => $item['finalizado'] ?? false,
                'CONCLUIDA' => $item['concluida'] ?? false,
                'CANCELADA' => $item['cancelada'] ?? false,
                'PENDENTE' => $item['pendente'] ?? false,
                'BLOQUEIA_EDICAO' => $item['bloqueia_edicao'] ?? false,
                'GERA_HISTORICO' => $item['gera_historico'] ?? true,
            ];
        }

        return $registros;
    }

    public static function classes(): array
    {
        $classes = [];
        $path = __DIR__;

        $files = new \FilesystemIterator($path, \FilesystemIterator::SKIP_DOTS);
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php' || $file->getBasename('.php') === 'Dominio') {
                continue;
            }

            $className = 'App\\Dominios\\' . $file->getBasename('.php');

            if (! class_exists($className)) {
                continue;
            }

            $reflection = new \ReflectionClass($className);
            if (! $reflection->isAbstract() && $reflection->isSubclassOf(self::class)) {
                $classes[] = $className;
            }
        }

        return $classes;
    }

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
