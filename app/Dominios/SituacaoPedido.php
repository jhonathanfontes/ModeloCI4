<?php

namespace App\Dominios;

class SituacaoPedido extends Dominio
{
    public const MODULO = 'SITUACAO_PEDIDO';

    public const SOLICITADO = 'SOLICITADO';
    public const COTACAO = 'COTACAO';
    public const AGUARDANDO_APROVACAO = 'AGUARDANDO_APROVACAO';
    public const APROVADO = 'APROVADO';
    public const COMPRADO = 'COMPRADO';
    public const RECEBIDO = 'RECEBIDO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::SOLICITADO => [
                'id_situacao' => 11,
                'codigo' => self::SOLICITADO,
                'descricao' => 'Solicitado',
                'cor' => 'primary',
                'icone' => 'fas fa-file-invoice',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::COTACAO => [
                'id_situacao' => 12,
                'codigo' => self::COTACAO,
                'descricao' => 'Cotação',
                'cor' => 'info',
                'icone' => 'fas fa-file-alt',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::AGUARDANDO_APROVACAO => [
                'id_situacao' => 13,
                'codigo' => self::AGUARDANDO_APROVACAO,
                'descricao' => 'Aguardando Aprovação',
                'cor' => 'warning',
                'icone' => 'fas fa-hourglass-half',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => true,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::APROVADO => [
                'id_situacao' => 14,
                'codigo' => self::APROVADO,
                'descricao' => 'Aprovado',
                'cor' => 'success',
                'icone' => 'fas fa-check-circle',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::COMPRADO => [
                'id_situacao' => 15,
                'codigo' => self::COMPRADO,
                'descricao' => 'Comprado',
                'cor' => 'success',
                'icone' => 'fas fa-shopping-cart',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::RECEBIDO => [
                'id_situacao' => 16,
                'codigo' => self::RECEBIDO,
                'descricao' => 'Recebido',
                'cor' => 'success',
                'icone' => 'fas fa-box',
                'finalizado' => true,
                'concluida' => true,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

        ];
    }
}
