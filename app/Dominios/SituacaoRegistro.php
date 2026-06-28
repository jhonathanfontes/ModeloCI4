<?php

namespace App\Dominios;

class SituacaoRegistro
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

    public const MODULO_PEDIDO = 'SITUACAO_PEDIDO';
    public const MODULO_FINANCEIRA = 'SITUACAO_FINANCEIRA';
    public const MODULO_PROCESSO = 'SITUACAO_PROCESSO';
    public const MODULO_ORDEM_SERVICO = 'SITUACAO_ORDEM_SERVICO';
    public const MODULO_RECRUTAMENTO = 'SITUACAO_RECRUTAMENTO';

    public static function classes(): array
    {
        return [
            SituacaoGeral::class,
            SituacaoPedido::class,
            SituacaoFinanceira::class,
            SituacaoProcesso::class,
            SituacaoOrdemServico::class,
            SituacaoRecrutamento::class,
        ];
    }

    public static function lista(): array
    {
        $todos = [];
        foreach (static::classes() as $classe) {
            $modulo = $classe::modulo();
            foreach ($classe::lista() as $codigo => $item) {
                $item['modulo'] = $modulo;
                $todos[$codigo] = $item;
            }
        }
        return $todos;
    }

    public static function dadosBanco(): array
    {
        $registros = [];
        foreach (static::classes() as $classe) {
            $modulo = $classe::modulo();
            foreach ($classe::lista() as $codigo => $item) {
                $registros[] = [
                    'ID_SITUACAO' => $item['id_situacao'],
                    'UUID' => \App\Helpers\Uuid::generate('SIST_SITUACOES_' . $modulo . '_' . $codigo),
                    'MODULO' => $modulo,
                    'CODIGO' => $codigo,
                    'DESCRICAO' => $item['descricao'],
                    'COR' => $item['cor'],
                    'ICONE' => $item['icone'],
                    'FINALIZADO' => $item['finalizado'] ?? false,
                    'CONCLUIDA' => $item['concluida'] ?? false,
                    'CANCELADA' => $item['cancelada'] ?? false,
                    'PENDENTE' => $item['pendente'] ?? false,
                    'BLOQUEIA_EDICAO' => $item['bloqueia_edicao'] ?? false,
                    'GERA_HISTORICO' => $item['gera_historico'] ?? true,
                ];
            }
        }
        return $registros;
    }

    public static function listarPorModulo(string $modulo): array
    {
        return array_filter(
            static::lista(),
            fn(array $item) => ($item['modulo'] ?? '') === $modulo
        );
    }

    public static function item(string $codigo): ?array
    {
        return static::lista()[$codigo] ?? null;
    }

    public static function descricao(string $codigo): string
    {
        return static::item($codigo)['descricao'] ?? '';
    }

    public static function cor(string $codigo): string
    {
        return static::item($codigo)['cor'] ?? 'secondary';
    }

    public static function icone(string $codigo): string
    {
        return static::item($codigo)['icone'] ?? '';
    }

}
