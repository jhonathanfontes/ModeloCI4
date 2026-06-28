<?php

namespace App\Dominios;

class TipoEndereco extends Dominio
{
    public const MODULO = 'TIPO_ENDERECO';

    public const RESIDENCIAL = 'RESIDENCIAL';
    public const COMERCIAL = 'COMERCIAL';
    public const COBRANCA = 'COBRANCA';
    public const ENTREGA = 'ENTREGA';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::RESIDENCIAL => [ 
                'id_tipo' => 3,
                'codigo' => self::RESIDENCIAL,
                'descricao' => 'Residencial',
                'ordem' => 10,
            ],
            self::COMERCIAL => [
                'id_tipo' => 4,
                'codigo' => self::COMERCIAL,
                'descricao' => 'Comercial',
                'ordem' => 11,
            ],
            self::COBRANCA => [
                'id_tipo' => 6,
                'codigo' => self::COBRANCA,
                'descricao' => 'Cobrança',
                'ordem' => 12,
            ],
            self::ENTREGA => [
                'id_tipo' => 5,
                'codigo' => self::ENTREGA,
                'descricao' => 'Entrega',
                'ordem' => 13,
            ],
        ];
    }

    public static function isEmpresa(): array
    {
        return self::obter([
            self::COMERCIAL,
            self::ENTREGA,
        ]);
    }
}
