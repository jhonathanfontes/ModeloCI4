<?php

namespace App\Dominios;

class SituacaoOrdemServico extends Dominio
{
    public const MODULO = 'SITUACAO_ORDEM_SERVICO';

    public const ABERTA             = 'O301';
    public const EM_ATENDIMENTO     = 'O302';
    public const AGUARDANDO_PECA    = 'O303';
    public const CONCLUIDA          = 'O304';
    public const ENCERRADA          = 'O305';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::ABERTA => [
                'codigo'    => self::ABERTA,
                'descricao' => 'Aberta',
                'cor'       => 'primary',
                'icone'     => 'fas fa-file-invoice',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::EM_ATENDIMENTO => [
                'codigo'    => self::EM_ATENDIMENTO,
                'descricao' => 'Em Atendimento',
                'cor'       => 'info',
                'icone'     => 'fas fa-tools',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::AGUARDANDO_PECA => [
                'codigo'    => self::AGUARDANDO_PECA,
                'descricao' => 'Aguardando Peça',
                'cor'       => 'warning',
                'icone'     => 'fas fa-hourglass-half',
                'finalizado'      => false,
                'concluida'       => false,
                'cancelada'       => false,
                'pendente'        => true,
                'bloqueia_edicao' => false,
                'gera_historico'  => true,
            ],

            self::CONCLUIDA => [
                'codigo'    => self::CONCLUIDA,
                'descricao' => 'Concluída',
                'cor'       => 'success',
                'icone'     => 'fas fa-check-circle',
                'finalizado'      => false,
                'concluida'       => true,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

            self::ENCERRADA => [
                'codigo'    => self::ENCERRADA,
                'descricao' => 'Encerrada',
                'cor'       => 'dark',
                'icone'     => 'fas fa-archive',
                'finalizado'      => true,
                'concluida'       => true,
                'cancelada'       => false,
                'pendente'        => false,
                'bloqueia_edicao' => true,
                'gera_historico'  => true,
            ],

        ];
    }
}
