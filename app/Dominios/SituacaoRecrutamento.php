<?php

namespace App\Dominios;

class SituacaoRecrutamento extends Dominio
{
    public const MODULO = 'SITUACAO_RECRUTAMENTO';

    public const SOLICITADO = 'R301';
    public const TRIAGEM = 'R302';
    public const ENTREVISTA = 'R303';
    public const APROVADO = 'R304';
    public const CONTRATADO = 'R305';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::SOLICITADO => [
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
