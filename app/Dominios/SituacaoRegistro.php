<?php

namespace App\Dominios;

class SituacaoRegistro extends Dominio
{
    public const MODULO = 'SITUACAO_REGISTRO';

    public const HABILITADO   = 'S101';
    public const DESABILITADO = 'S102';
    public const ATIVO       = 'S201';
    public const INATIVO     = 'S202';
    public const PENDENTE    = 'S203';
    public const BLOQUEADO   = 'S204';
    public const CANCELADO   = 'S205';
    public const EXCLUIDO    = 'S206';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::HABILITADO => [
                'codigo'    => self::HABILITADO,
                'descricao' => 'Habilitado',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::DESABILITADO => [
                'codigo'    => self::DESABILITADO,
                'descricao' => 'Desabilitado',
                'cor'       => 'danger',
                'icone'     => 'fas fa-ban',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

            self::ATIVO => [
                'codigo'    => self::ATIVO,
                'descricao' => 'Ativo',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::INATIVO => [
                'codigo'    => self::INATIVO,
                'descricao' => 'Inativo',
                'cor'       => 'secondary',
                'icone'     => 'fas fa-pause-circle',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

            self::BLOQUEADO => [
                'codigo'    => self::BLOQUEADO,
                'descricao' => 'Bloqueado',
                'cor'       => 'danger',
                'icone'     => 'fas fa-lock',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

            self::PENDENTE => [
                'codigo'    => self::PENDENTE,
                'descricao' => 'Pendente',
                'cor'       => 'warning',
                'icone'     => 'fas fa-clock',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => true,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::CANCELADO => [
                'codigo'    => self::CANCELADO,
                'descricao' => 'Cancelado',
                'cor'       => 'dark',
                'icone'     => 'fas fa-ban',
                'finalizado'      => true,
                'concluida'       => false,
                'cancelada'       => true,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

            self::EXCLUIDO => [
                'codigo'    => self::EXCLUIDO,
                'descricao' => 'Excluído',
                'cor'       => 'danger',
                'icone'     => 'fas fa-trash',
                'finalizado'      => true,
                'concluida'       => false,
                'cancelada'       => true,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

        ];
    }

    public static function cadastro(): array
    {
        return self::obter([
            self::HABILITADO,
            self::DESABILITADO
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
            self::EXCLUIDO
        ]);
    }

    public static function usuario(): array
    {
        return self::obter([
            self::ATIVO,
            self::INATIVO,
            self::PENDENTE,
            self::BLOQUEADO
        ]);
    }
}
