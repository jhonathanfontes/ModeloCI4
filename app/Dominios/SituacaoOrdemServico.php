<?php

namespace App\Dominios;

class SituacaoOrdemServico extends Dominio
{
    public const MODULO = 'SITUACAO_ORDEM_SERVICO';

    public const ABERTA = 'ABERTA';
    public const EM_ATENDIMENTO = 'EM_ATENDIMENTO';
    public const AGUARDANDO_PECA = 'AGUARDANDO_PECA';
    public const CONCLUIDA = 'CONCLUIDA';
    public const ENCERRADA = 'ENCERRADA';

    public static function modulo(): string
    {
        return self::MODULO;
    }

    public static function lista(): array
    {
        return [

            self::ABERTA => [
                'id_situacao' => 50,
                'codigo' => self::ABERTA,
                'descricao' => 'Aberta',
                'cor' => 'primary',
                'icone' => 'fas fa-file-invoice',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::EM_ATENDIMENTO => [
                'id_situacao' => 51,
                'codigo' => self::EM_ATENDIMENTO,
                'descricao' => 'Em Atendimento',
                'cor' => 'info',
                'icone' => 'fas fa-tools',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::AGUARDANDO_PECA => [
                'id_situacao' => 52,
                'codigo' => self::AGUARDANDO_PECA,
                'descricao' => 'Aguardando Peça',
                'cor' => 'warning',
                'icone' => 'fas fa-hourglass-half',
                'finalizado' => false,
                'concluida' => false,
                'cancelada' => false,
                'pendente' => true,
                'bloqueia_edicao' => false,
                'gera_historico' => true,
            ],

            self::CONCLUIDA => [
                'id_situacao' => 53,
                'codigo' => self::CONCLUIDA,
                'descricao' => 'Concluída',
                'cor' => 'success',
                'icone' => 'fas fa-check-circle',
                'finalizado' => false,
                'concluida' => true,
                'cancelada' => false,
                'pendente' => false,
                'bloqueia_edicao' => true,
                'gera_historico' => true,
            ],

            self::ENCERRADA => [
                'id_situacao' => 54,
                'codigo' => self::ENCERRADA,
                'descricao' => 'Encerrada',
                'cor' => 'dark',
                'icone' => 'fas fa-archive',
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
