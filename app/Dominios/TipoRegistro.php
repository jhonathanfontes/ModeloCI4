<?php

namespace App\Dominios;

class TipoRegistro
{
    public const MODULO_PESSOA = 'TIPO_PESSOA';
    public const MODULO_ENDERECO = 'TIPO_ENDERECO';
    public const MODULO_PERIODO = 'TIPO_PERIODO';
    public const MODULO_CONTATO = 'TIPO_CONTATO';
    public const MODULO_FUNCIONARIO = 'TIPO_FUNCIONARIO';
    public const MODULO_PRODUTO = 'TIPO_PRODUTO';
    public const MODULO_SERVICO = 'TIPO_SERVICO';
    public const MODULO_GERAL = 'TIPO_GERAL';

    public const PF = 'PF';
    public const PJ = 'PJ';
    public const RESIDENCIAL = 'RESIDENCIAL';
    public const COMERCIAL = 'COMERCIAL';
    public const COBRANCA = 'COBRANCA';
    public const ENTREGA = 'ENTREGA';
    public const MENSAL = 'MENSAL';
    public const ANUAL = 'ANUAL';
    public const COMERCIAL_CONTATO = 'COMERCIAL';
    public const FINANCEIRO = 'FINANCEIRO';
    public const ADMINISTRATIVO = 'ADMINISTRATIVO';
    public const TECNICO = 'TECNICO';
    public const RH = 'RH';
    public const CLT = 'CLT';
    public const ESTAGIARIO = 'ESTAGIARIO';
    public const TERCEIRO = 'TERCEIRO';
    public const AUTONOMO = 'AUTONOMO';
    public const DIRETOR = 'DIRETOR';
    public const SOCIO = 'SOCIO';
    public const PRODUTO_ACABADO = 'PRODUTO_ACABADO';
    public const MATERIA_PRIMA = 'MATERIA_PRIMA';
    public const INSUMO = 'INSUMO';
    public const PRODUTO_SERVICO = 'SERVICO';
    public const COMPOSTO = 'COMPOSTO';
    public const SERVICO_AVULSO = 'SERVICO_AVULSO';
    public const SERVICO_RECORRENTE = 'SERVICO_RECORRENTE';
    public const CONSULTORIA = 'CONSULTORIA';
    public const MANUTENCAO = 'MANUTENCAO';
    public const TREINAMENTO = 'TREINAMENTO';

    public static function classes(): array
    {
        return [
            TipoPessoa::class,
            TipoEndereco::class,
            TipoPeriodo::class,
            TipoContato::class,
            TipoFuncionario::class,
            TipoProduto::class,
            TipoServico::class,
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
                    'ID_TIPO' => $item['id_tipo'],
                    'UUID' => \App\Helpers\Uuid::generate('SIST_TIPOS_' . $codigo . '_' . microtime()),
                    'MODULO' => $modulo,
                    'CODIGO' => $codigo,
                    'DESCRICAO' => $item['descricao'],
                    'ORDEM' => $item['ordem'],
                    'SITUACAO_ID' => 1,
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

}
