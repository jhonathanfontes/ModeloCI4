<?php

namespace App\Dominios;

class SituacaoPedido extends Dominio
{
    public const SOLICITADO            = 'C301';
    public const COTACAO               = 'C302';
    public const AGUARDANDO_APROVACAO  = 'C303';
    public const APROVADO              = 'C304';
    public const COMPRADO              = 'C305';
    public const RECEBIDO              = 'C306';

    public static function lista(): array
    {
        return [

            self::SOLICITADO => [
                'codigo'    => self::SOLICITADO,
                'descricao' => 'Solicitado',
                'cor'       => 'primary',
                'icone'     => 'fas fa-file-invoice'
            ],

            self::COTACAO => [
                'codigo'    => self::COTACAO,
                'descricao' => 'Cotação',
                'cor'       => 'info',
                'icone'     => 'fas fa-file-alt'
            ],

            self::AGUARDANDO_APROVACAO => [
                'codigo'    => self::AGUARDANDO_APROVACAO,
                'descricao' => 'Aguardando Aprovação',
                'cor'       => 'warning',
                'icone'     => 'fas fa-hourglass-half'
            ],

            self::APROVADO => [
                'codigo'    => self::APROVADO,
                'descricao' => 'Aprovado',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle'
            ],

            self::COMPRADO => [
                'codigo'    => self::COMPRADO,
                'descricao' => 'Comprado',
                'cor'       => 'success',
                'icone'     => 'fas fa-shopping-cart'
            ],

            self::RECEBIDO => [
                'codigo'    => self::RECEBIDO,
                'descricao' => 'Recebido',
                'cor'       => 'success',
                'icone'     => 'fas fa-box'
            ],

        ];
    }
}
