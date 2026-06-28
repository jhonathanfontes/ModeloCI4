<?php

namespace App\Dominios;

class TipoProduto extends Dominio
{
    public const MODULO = 'TIPO_PRODUTO';

    public const PRODUTO_ACABADO = 'PRODUTO_ACABADO';
    public const MATERIA_PRIMA = 'MATERIA_PRIMA';
    public const INSUMO = 'INSUMO';
    public const SERVICO = 'SERVICO';
    public const COMPOSTO = 'COMPOSTO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [
            self::PRODUTO_ACABADO => [
                'id_tipo' => 30,
                'codigo' => self::PRODUTO_ACABADO,
                'descricao' => 'Produto Acabado',
                'ordem' => 10,
            ],
            self::MATERIA_PRIMA => [
                'id_tipo' => 31,
                'codigo' => self::MATERIA_PRIMA,
                'descricao' => 'Matéria-Prima',
                'ordem' => 20,
            ],
            self::INSUMO => [
                'id_tipo' => 32,
                'codigo' => self::INSUMO,
                'descricao' => 'Insumo',
                'ordem' => 30,
            ],
            self::SERVICO => [
                'id_tipo' => 33,
                'codigo' => self::SERVICO,
                'descricao' => 'Serviço',
                'ordem' => 40,
            ],
            self::COMPOSTO => [
                'id_tipo' => 34,
                'codigo' => self::COMPOSTO,
                'descricao' => 'Composto',
                'ordem' => 50,
            ],
        ];
    }
}
