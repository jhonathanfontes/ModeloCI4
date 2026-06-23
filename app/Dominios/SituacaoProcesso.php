<?php

namespace App\Dominios;

class SituacaoProcesso extends Dominio
{
    public const MODULO = 'SITUACAO_PROCESSO';

    public const RASCUNHO = 'P101';
    public const PENDENTE = 'P102';
    public const EM_ANALISE = 'P103';
    public const APROVADO = 'P104';
    public const REPROVADO = 'P105';
    public const DEVOLVIDO = 'P106';
    public const AGUARDANDO = 'P107';
    public const EM_EXECUCAO = 'P108';
    public const SUSPENSO = 'P109';
    public const FINALIZADO = 'P110';
    public const CANCELADO = 'P111';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::RASCUNHO => [
                'codigo' => self::RASCUNHO,
                'descricao' => 'Rascunho',
                'cor' => 'secondary',
                'icone' => 'fas fa-pencil-alt',
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

            self::EM_ANALISE => [
                'codigo' => self::EM_ANALISE,
                'descricao' => 'Em Análise',
                'cor' => 'info',
                'icone' => 'fas fa-search',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
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

            self::REPROVADO => [
                'codigo' => self::REPROVADO,
                'descricao' => 'Reprovado',
                'cor' => 'danger',
                'icone' => 'fas fa-times-circle',
                'finalizado' => true,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::DEVOLVIDO => [
                'codigo' => self::DEVOLVIDO,
                'descricao' => 'Devolvido',
                'cor' => 'warning',
                'icone' => 'fas fa-reply',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::AGUARDANDO => [
                'codigo' => self::AGUARDANDO,
                'descricao' => 'Aguardando',
                'cor' => 'primary',
                'icone' => 'fas fa-hourglass-half',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => true,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::EM_EXECUCAO => [
                'codigo' => self::EM_EXECUCAO,
                'descricao' => 'Em Execução',
                'cor' => 'primary',
                'icone' => 'fas fa-cogs',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::SUSPENSO => [
                'codigo' => self::SUSPENSO,
                'descricao' => 'Suspenso',
                'cor' => 'dark',
                'icone' => 'fas fa-pause-circle',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::FINALIZADO => [
                'codigo' => self::FINALIZADO,
                'descricao' => 'Finalizado',
                'cor' => 'success',
                'icone' => 'fas fa-flag-checkered',
                'finalizado' => true,
                'concluida' => true,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::CANCELADO => [
                'codigo' => self::CANCELADO,
                'descricao' => 'Cancelado',
                'cor' => 'danger',
                'icone' => 'fas fa-ban',
                'finalizado' => true,
                'concluida' => false,
                'cancelada' => true,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

        ];
    }
}
