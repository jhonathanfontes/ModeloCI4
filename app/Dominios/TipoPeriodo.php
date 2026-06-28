<?php

namespace App\Dominios;

class TipoPeriodo extends Dominio
{
    public const MODULO = 'TIPO_PERIODO';

    public const MENSAL = 'MENSAL';
    public const ANUAL = 'ANUAL';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::MENSAL => [
                'id_tipo' => 8,
                'codigo' => self::MENSAL,
                'descricao' => 'Mensal',
                'ordem' => 20,
            ],
            self::ANUAL => [
                'id_tipo' => 9,
                'codigo' => self::ANUAL,
                'descricao' => 'Anual',
                'ordem' => 21,
            ],
        ];
    }
}
