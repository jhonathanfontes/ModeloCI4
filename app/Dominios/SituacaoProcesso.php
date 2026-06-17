<?php

namespace App\Dominios;

class SituacaoProcesso extends Dominio
{
    public const RASCUNHO      = 'P101';
    public const PENDENTE      = 'P102';
    public const EM_ANALISE    = 'P103';
    public const APROVADO      = 'P104';
    public const REPROVADO     = 'P105';
    public const DEVOLVIDO     = 'P106';
    public const AGUARDANDO    = 'P107';
    public const EM_EXECUCAO   = 'P108';
    public const SUSPENSO      = 'P109';
    public const FINALIZADO    = 'P110';
    public const CANCELADO     = 'P111';

    public static function lista(): array
    {
        return [

            self::RASCUNHO => [
                'codigo'    => self::RASCUNHO,
                'descricao' => 'Rascunho',
                'cor'       => 'secondary',
                'icone'     => 'fas fa-pencil-alt'
            ],

            self::PENDENTE => [
                'codigo'    => self::PENDENTE,
                'descricao' => 'Pendente',
                'cor'       => 'warning',
                'icone'     => 'fas fa-clock'
            ],

            self::EM_ANALISE => [
                'codigo'    => self::EM_ANALISE,
                'descricao' => 'Em Análise',
                'cor'       => 'info',
                'icone'     => 'fas fa-search'
            ],

            self::APROVADO => [
                'codigo'    => self::APROVADO,
                'descricao' => 'Aprovado',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle'
            ],

            self::REPROVADO => [
                'codigo'    => self::REPROVADO,
                'descricao' => 'Reprovado',
                'cor'       => 'danger',
                'icone'     => 'fas fa-times-circle'
            ],

            self::DEVOLVIDO => [
                'codigo'    => self::DEVOLVIDO,
                'descricao' => 'Devolvido',
                'cor'       => 'warning',
                'icone'     => 'fas fa-reply'
            ],

            self::AGUARDANDO => [
                'codigo'    => self::AGUARDANDO,
                'descricao' => 'Aguardando',
                'cor'       => 'primary',
                'icone'     => 'fas fa-hourglass-half'
            ],

            self::EM_EXECUCAO => [
                'codigo'    => self::EM_EXECUCAO,
                'descricao' => 'Em Execução',
                'cor'       => 'primary',
                'icone'     => 'fas fa-cogs'
            ],

            self::SUSPENSO => [
                'codigo'    => self::SUSPENSO,
                'descricao' => 'Suspenso',
                'cor'       => 'dark',
                'icone'     => 'fas fa-pause-circle'
            ],

            self::FINALIZADO => [
                'codigo'    => self::FINALIZADO,
                'descricao' => 'Finalizado',
                'cor'       => 'success',
                'icone'     => 'fas fa-flag-checkered'
            ],

            self::CANCELADO => [
                'codigo'    => self::CANCELADO,
                'descricao' => 'Cancelado',
                'cor'       => 'danger',
                'icone'     => 'fas fa-ban'
            ],

        ];
    }
}