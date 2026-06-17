<?php

namespace App\Dominios;

class SituacaoOrdemServico extends Dominio
{
    public const ABERTA             = 'O301';
    public const EM_ATENDIMENTO     = 'O302';
    public const AGUARDANDO_PECA    = 'O303';
    public const CONCLUIDA          = 'O304';
    public const ENCERRADA          = 'O305';

    public static function lista(): array
    {
        return [

            self::ABERTA => [
                'codigo'    => self::ABERTA,
                'descricao' => 'Aberta',
                'cor'       => 'primary',
                'icone'     => 'fas fa-file-invoice'
            ],

            self::EM_ATENDIMENTO => [
                'codigo'    => self::EM_ATENDIMENTO,
                'descricao' => 'Em Atendimento',
                'cor'       => 'info',
                'icone'     => 'fas fa-tools'
            ],

            self::AGUARDANDO_PECA => [
                'codigo'    => self::AGUARDANDO_PECA,
                'descricao' => 'Aguardando Peça',
                'cor'       => 'warning',
                'icone'     => 'fas fa-hourglass-half'
            ],

            self::CONCLUIDA => [
                'codigo'    => self::CONCLUIDA,
                'descricao' => 'Concluída',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle'
            ],

            self::ENCERRADA => [
                'codigo'    => self::ENCERRADA,
                'descricao' => 'Encerrada',
                'cor'       => 'dark',
                'icone'     => 'fas fa-archive'
            ],

        ];
    }
}
