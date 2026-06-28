<?php

namespace App\Dominios;

class TipoFuncionario extends Dominio
{
    public const MODULO = 'TIPO_FUNCIONARIO';

    public const CLT = 'CLT';
    public const ESTAGIARIO = 'ESTAGIARIO';
    public const TERCEIRO = 'TERCEIRO';
    public const AUTONOMO = 'AUTONOMO';
    public const DIRETOR = 'DIRETOR';
    public const SOCIO = 'SOCIO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::CLT => [
                'id_tipo' => 20,
                'codigo' => self::CLT,
                'descricao' => 'CLT',
                'ordem' => 10,
            ],
            self::ESTAGIARIO => [
                'id_tipo' => 21,
                'codigo' => self::ESTAGIARIO,
                'descricao' => 'Estagiário',
                'ordem' => 20,
            ],
            self::TERCEIRO => [
                'id_tipo' => 22,
                'codigo' => self::TERCEIRO,
                'descricao' => 'Terceiro',
                'ordem' => 30,
            ],
            self::AUTONOMO => [
                'id_tipo' => 23,
                'codigo' => self::AUTONOMO,
                'descricao' => 'Autônomo',
                'ordem' => 40,
            ],
            self::DIRETOR => [
                'id_tipo' => 24,
                'codigo' => self::DIRETOR,
                'descricao' => 'Diretor',
                'ordem' => 50,
            ],
            self::SOCIO => [
                'id_tipo' => 25,
                'codigo' => self::SOCIO,
                'descricao' => 'Sócio',
                'ordem' => 60,
            ],
        ];
    }
}
