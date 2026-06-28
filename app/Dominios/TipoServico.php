<?php

namespace App\Dominios;

class TipoServico extends Dominio
{
    public const MODULO = 'TIPO_SERVICO';

    public const SERVICO_AVULSO = 'SERVICO_AVULSO';
    public const SERVICO_RECORRENTE = 'SERVICO_RECORRENTE';
    public const CONSULTORIA = 'CONSULTORIA';
    public const MANUTENCAO = 'MANUTENCAO';
    public const TREINAMENTO = 'TREINAMENTO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::SERVICO_AVULSO => [
                'id_tipo' => 40,
                'codigo' => self::SERVICO_AVULSO,
                'descricao' => 'Serviço Avulso',
                'ordem' => 10,
            ],
            self::SERVICO_RECORRENTE => [
                'id_tipo' => 41,
                'codigo' => self::SERVICO_RECORRENTE,
                'descricao' => 'Serviço Recorrente',
                'ordem' => 20,
            ],
            self::CONSULTORIA => [
                'id_tipo' => 42,
                'codigo' => self::CONSULTORIA,
                'descricao' => 'Consultoria',
                'ordem' => 30,
            ],
            self::MANUTENCAO => [
                'id_tipo' => 43,
                'codigo' => self::MANUTENCAO,
                'descricao' => 'Manutenção',
                'ordem' => 40,
            ],
            self::TREINAMENTO => [
                'id_tipo' => 44,
                'codigo' => self::TREINAMENTO,
                'descricao' => 'Treinamento',
                'ordem' => 50,
            ],
        ];
    }
}
