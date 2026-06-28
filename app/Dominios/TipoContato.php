<?php

namespace App\Dominios;

class TipoContato extends Dominio
{
    public const MODULO = 'TIPO_CONTATO';

    public const COMERCIAL = 'COMERCIAL';
    public const FINANCEIRO = 'FINANCEIRO';
    public const ADMINISTRATIVO = 'ADMINISTRATIVO';
    public const TECNICO = 'TECNICO';
    public const RH = 'RH';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::COMERCIAL => [
                'id_tipo' => 10,
                'codigo' => self::COMERCIAL,
                'descricao' => 'Comercial',
                'ordem' => 10,
            ],
            self::FINANCEIRO => [
                'id_tipo' => 11,
                'codigo' => self::FINANCEIRO,
                'descricao' => 'Financeiro',
                'ordem' => 20,
            ],
            self::ADMINISTRATIVO => [
                'id_tipo' => 12,
                'codigo' => self::ADMINISTRATIVO,
                'descricao' => 'Administrativo',
                'ordem' => 30,
            ],
            self::TECNICO => [
                'id_tipo' => 13,
                'codigo' => self::TECNICO,
                'descricao' => 'Técnico',
                'ordem' => 40,
            ],
            self::RH => [
                'id_tipo' => 14,
                'codigo' => self::RH,
                'descricao' => 'RH',
                'ordem' => 50,
            ],
        ];
    }
}
