<?php

namespace App\Dominios;

class SituacaoFinanceira extends Dominio
{
    public const MODULO = 'SITUACAO_FINANCEIRA';

    public const ABERTO = 'ABERTO';
    public const PAGO = 'PAGO';
    public const PENDENTE = 'PENDENTE';
    public const PARCIAL = 'PARCIAL';
    public const VENCIDO = 'VENCIDO';
    public const NEGOCIADO = 'NEGOCIADO';
    public const CANCELADO = 'CANCELADO';
    public const ESTORNADO = 'ESTORNADO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::ABERTO => [
                'id_situacao' => 20,
                'codigo' => self::ABERTO,
                'descricao' => 'Aberto',
                'cor' => 'primary',
                'icone' => 'fas fa-file-invoice',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::PENDENTE => [
                'id_situacao' => 22,
                'codigo' => self::PENDENTE,
                'descricao' => 'Pendente',
                'cor' => 'warning',
                'icone' => 'fas fa-clock',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => true,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::PARCIAL => [
                'id_situacao' => 23,
                'codigo' => self::PARCIAL,
                'descricao' => 'Pagamento Parcial',
                'cor' => 'info',
                'icone' => 'fas fa-coins',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::PAGO => [
                'id_situacao' => 21,
                'codigo' => self::PAGO,
                'descricao' => 'Pago',
                'cor' => 'success',
                'icone' => 'fas fa-check-circle',
                'finalizado' => true,
                'concluida' => true,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::VENCIDO => [
                'id_situacao' => 24,
                'codigo' => self::VENCIDO,
                'descricao' => 'Vencido',
                'cor' => 'danger',
                'icone' => 'fas fa-calendar-times',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::NEGOCIADO => [
                'id_situacao' => 25,
                'codigo' => self::NEGOCIADO,
                'descricao' => 'Negociado',
                'cor' => 'secondary',
                'icone' => 'fas fa-handshake',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::CANCELADO => [
                'id_situacao' => 26,
                'codigo' => self::CANCELADO,
                'descricao' => 'Cancelado',
                'cor' => 'dark',
                'icone' => 'fas fa-ban',
                'finalizado' => true,
                'concluida' => false,
                'cancelada' => true,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::ESTORNADO => [
                'id_situacao' => 27,
                'codigo' => self::ESTORNADO,
                'descricao' => 'Estornado',
                'cor' => 'danger',
                'icone' => 'fas fa-undo',
                'finalizado' => true,
                'concluida' => false,
                'cancelada' => true,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

        ];
    }

    public static function contapagar(): array
    {
        return self::obter([
            self::ABERTO,
            self::PAGO,
            self::PENDENTE,
            self::VENCIDO,
            self::CANCELADO,
        ]);
    }

    public static function contareceber(): array
    {
        return self::obter([
            self::ABERTO,
            self::PAGO,
            self::PENDENTE,
            self::VENCIDO,
            self::NEGOCIADO,
            self::CANCELADO,
        ]);
    }
}
