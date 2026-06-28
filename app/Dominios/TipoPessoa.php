<?php

namespace App\Dominios;

class TipoPessoa extends Dominio
{
    public const MODULO = 'TIPO_PESSOA';

    public const PF = 'PF';
    public const PJ = 'PJ';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::PF => [
                'id_tipo' => 1,
                'codigo' => self::PF,
                'descricao' => 'Pessoa Física',
                'ordem' => 1,
            ],
            self::PJ => [
                'id_tipo' => 2,
                'codigo' => self::PJ,
                'descricao' => 'Pessoa Jurídica',
                'ordem' => 2,
            ],
        ];
    }
}
