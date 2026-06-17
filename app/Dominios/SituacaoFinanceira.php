<?php

namespace App\Dominios;

class SituacaoFinanceira extends Dominio
{
    public const ABERTO      = 'F301';
    public const PAGO        = 'F302'; 
    public const PENDENTE    = 'F303';
    public const PARCIAL     = 'F304';
    public const VENCIDO     = 'F305';
    public const NEGOCIADO   = 'F306';
    public const CANCELADO   = 'F307';
    public const ESTORNADO   = 'F308';

    public static function lista(): array
    {
        return [

            self::ABERTO => [
                'codigo'    => self::ABERTO,
                'descricao' => 'Aberto',
                'cor'       => 'primary',
                'icone'     => 'fas fa-file-invoice'
            ],

            self::PENDENTE => [
                'codigo'    => self::PENDENTE,
                'descricao' => 'Pendente',
                'cor'       => 'warning',
                'icone'     => 'fas fa-clock'
            ],

            self::PARCIAL => [
                'codigo'    => self::PARCIAL,
                'descricao' => 'Pagamento Parcial',
                'cor'       => 'info',
                'icone'     => 'fas fa-coins'
            ],

            self::PAGO => [
                'codigo'    => self::PAGO,
                'descricao' => 'Pago',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle'
            ],

            self::VENCIDO => [
                'codigo'    => self::VENCIDO,
                'descricao' => 'Vencido',
                'cor'       => 'danger',
                'icone'     => 'fas fa-calendar-times'
            ],

            self::NEGOCIADO => [
                'codigo'    => self::NEGOCIADO,
                'descricao' => 'Negociado',
                'cor'       => 'secondary',
                'icone'     => 'fas fa-handshake'
            ],

            self::CANCELADO => [
                'codigo'    => self::CANCELADO,
                'descricao' => 'Cancelado',
                'cor'       => 'dark',
                'icone'     => 'fas fa-ban'
            ],

            self::ESTORNADO => [
                'codigo'    => self::ESTORNADO,
                'descricao' => 'Estornado',
                'cor'       => 'danger',
                'icone'     => 'fas fa-undo'
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
            self::CANCELADO
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
            self::CANCELADO
        ]);
    }
}