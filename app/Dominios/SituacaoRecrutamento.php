<?php

namespace App\Dominios;

class SituacaoRecrutamento extends Dominio
{
    public const SOLICITADO   = 'R301';
    public const TRIAGEM      = 'R302';
    public const ENTREVISTA   = 'R303';
    public const APROVADO     = 'R304';
    public const CONTRATADO   = 'R305';

    public static function lista(): array
    {
        return [

            self::SOLICITADO => [
                'codigo'    => self::SOLICITADO,
                'descricao' => 'Solicitado',
                'cor'       => 'primary',
                'icone'     => 'fas fa-file-invoice'
            ],

            self::TRIAGEM => [
                'codigo'    => self::TRIAGEM,
                'descricao' => 'Triagem',
                'cor'       => 'info',
                'icone'     => 'fas fa-filter'
            ],

            self::ENTREVISTA => [
                'codigo'    => self::ENTREVISTA,
                'descricao' => 'Entrevista',
                'cor'       => 'info',
                'icone'     => 'fas fa-users'
            ],

            self::APROVADO => [
                'codigo'    => self::APROVADO,
                'descricao' => 'Aprovado',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle'
            ],

            self::CONTRATADO => [
                'codigo'    => self::CONTRATADO,
                'descricao' => 'Contratado',
                'cor'       => 'success',
                'icone'     => 'fas fa-user-check'
            ],

        ];
    }
}
