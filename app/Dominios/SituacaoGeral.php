<?php

namespace App\Dominios;

class SituacaoGeral extends Dominio
{
    public const MODULO = 'SITUACAO_REGISTRO';

    public const HABILITADO = 'HABILITADO';
    public const DESABILITADO = 'DESABILITADO';
    public const ATIVO = 'ATIVO';
    public const INATIVO = 'INATIVO';
    public const PENDENTE = 'PENDENTE';
    public const BLOQUEADO = 'BLOQUEADO';
    public const CANCELADO = 'CANCELADO';
    public const EXCLUIDO = 'EXCLUIDO';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::HABILITADO => [
                'id_situacao' => 1,
                'codigo' => self::HABILITADO,
                'descricao' => 'Habilitado',
                'cor' => 'success',
                'icone' => 'fas fa-check-circle',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::DESABILITADO => [
                'id_situacao' => 2,
                'codigo' => self::DESABILITADO,
                'descricao' => 'Desabilitado',
                'cor' => 'danger',
                'icone' => 'fas fa-ban',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::ATIVO => [
                'id_situacao' => 3,
                'codigo' => self::ATIVO,
                'descricao' => 'Ativo',
                'cor' => 'success',
                'icone' => 'fas fa-check-circle',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::INATIVO => [
                'id_situacao' => 4,
                'codigo' => self::INATIVO,
                'descricao' => 'Inativo',
                'cor' => 'secondary',
                'icone' => 'fas fa-pause-circle',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::BLOQUEADO => [
                'id_situacao' => 6,
                'codigo' => self::BLOQUEADO,
                'descricao' => 'Bloqueado',
                'cor' => 'danger',
                'icone' => 'fas fa-lock',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::PENDENTE => [
                'id_situacao' => 5,
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

            self::CANCELADO => [
                'id_situacao' => 7,
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

            self::EXCLUIDO => [
                'id_situacao' => 8,
                'codigo' => self::EXCLUIDO,
                'descricao' => 'Excluído',
                'cor' => 'danger',
                'icone' => 'fas fa-trash',
                'finalizado' => true,
                'concluida' => false,
                'cancelada' => true,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

        ];
    }

    public static function isAtivo(): array
    {
        return self::obter([
            self::ATIVO,
            self::INATIVO,
        ]);
    }

    public static function isHabilitado(): array
    {
        return self::obter([
            self::HABILITADO,
            self::DESABILITADO,
        ]);
    }

    public static function situacao(): array
    {
        return self::obter([
            self::ATIVO,
            self::INATIVO,
            self::PENDENTE,
            self::BLOQUEADO,
            self::CANCELADO,
            self::EXCLUIDO,
        ]);
    }

    public static function usuario(): array
    {
        return self::obter([
            self::ATIVO,
            self::INATIVO,
            self::PENDENTE,
            self::BLOQUEADO,
        ]);
    }

    public static function empresa(): array
    {
        return self::obter([
            self::ATIVO,
            self::INATIVO,
            self::PENDENTE,
            self::BLOQUEADO,
        ]);
    }
}
