<?php

namespace App\Dominios;

class SituacaoFinanceira extends Dominio
{
    public const MODULO = 'SITUACAO_FINANCEIRA';

    public const ABERTO = 'F301';
    public const PAGO = 'F302';
    public const PENDENTE = 'F303';
    public const PARCIAL = 'F304';
    public const VENCIDO = 'F305';
    public const NEGOCIADO = 'F306';
    public const CANCELADO = 'F307';
    public const ESTORNADO = 'F308';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::ABERTO => [
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
