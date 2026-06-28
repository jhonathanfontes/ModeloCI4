<?php

namespace App\Dominios;

class SituacaoProcesso extends Dominio
{
    public const MODULO = 'SITUACAO_PROCESSO';

    public const RASCUNHO = 'RASCUNHO';
    public const PENDENTE = 'PENDENTE';
    public const EM_ANALISE = 'EM_ANALISE';
    public const APROVADO = 'APROVADO';
    public const REPROVADO = 'REPROVADO';
    public const DEVOLVIDO = 'DEVOLVIDO';
    public const AGUARDANDO = 'AGUARDANDO';
    public const EM_EXECUCAO = 'EM_EXECUCAO';
    public const SUSPENSO = 'SUSPENSO';
    public const FINALIZADO = 'FINALIZADO';
    public const CANCELADO = 'CANCELADO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::RASCUNHO => [
                'id_situacao' => 30,
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
                'id_situacao' => 31,
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
                'id_situacao' => 32,
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
                'id_situacao' => 33,
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
                'id_situacao' => 34,
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
                'id_situacao' => 35,
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
                'id_situacao' => 36,
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
                'id_situacao' => 37,
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
                'id_situacao' => 38,
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
                'id_situacao' => 39,
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
                'id_situacao' => 40,
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
