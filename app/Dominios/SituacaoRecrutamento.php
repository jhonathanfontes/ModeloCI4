<?php

namespace App\Dominios;

class SituacaoRecrutamento extends Dominio
{
    public const MODULO = 'SITUACAO_RECRUTAMENTO';

    public const SOLICITADO = 'SOLICITADO';
    public const TRIAGEM = 'TRIAGEM';
    public const ENTREVISTA = 'ENTREVISTA';
    public const APROVADO = 'APROVADO';
    public const CONTRATADO = 'CONTRATADO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::SOLICITADO => [
                'id_situacao' => 60,
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

            self::TRIAGEM => [
                'id_situacao' => 61,
                'codigo' => self::TRIAGEM,
                'descricao' => 'Triagem',
                'cor' => 'info',
                'icone' => 'fas fa-filter',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::ENTREVISTA => [
                'id_situacao' => 62,
                'codigo' => self::ENTREVISTA,
                'descricao' => 'Entrevista',
                'cor' => 'info',
                'icone' => 'fas fa-users',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::APROVADO => [
                'id_situacao' => 63,
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

            self::CONTRATADO => [
                'id_situacao' => 64,
                'codigo' => self::CONTRATADO,
                'descricao' => 'Contratado',
                'cor' => 'success',
                'icone' => 'fas fa-user-check',
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
