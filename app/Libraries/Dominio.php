<?php

namespace App\Libraries;

use App\Dominios\SituacaoGeral;
use App\Dominios\SituacaoRegistro;
use App\Dominios\TipoEndereco;
use App\Dominios\TipoRegistro;

class Dominio
{
    public static function situacoes(array $codigos, string $modulo): array
    {
        return array_values(array_map(
            fn(array $item) => [
                'ID_SITUACAO' => $item['ID_SITUACAO'],
                'DESCRICAO' => $item['DESCRICAO'],
                'COR' => $item['COR'],
                'ICONE' => $item['ICONE'],
            ],
            array_filter(
                SituacaoRegistro::dadosBanco(),
                fn(array $item) => $item['MODULO'] === $modulo
                    && in_array($item['CODIGO'], $codigos, true)
            )
        ));
    }

    public static function situacoesPorModulo(string $modulo): array
    {
        return array_values(array_map(
            fn(array $item) => [
                'ID_SITUACAO' => $item['ID_SITUACAO'],
                'DESCRICAO' => $item['DESCRICAO'],
                'COR' => $item['COR'],
                'ICONE' => $item['ICONE'],
            ],
            array_filter(
                SituacaoRegistro::dadosBanco(),
                fn(array $item) => $item['MODULO'] === $modulo
            )
        ));
    }

    public static function situacoesEmpresa(): array
    {
        return self::situacoes(
            array_keys(SituacaoGeral::empresa()),
            SituacaoGeral::modulo()
        );
    }

    public static function situacoesUsuario(): array
    {
        return self::situacoes(
            array_keys(SituacaoGeral::usuario()),
            SituacaoGeral::modulo()
        );
    }

    public static function situacoesAtivo(): array
    {
        return self::situacoes(
            array_keys(SituacaoGeral::isAtivo()),
            SituacaoGeral::modulo()
        );
    }

    public static function situacoesHabilitado(): array
    {
        return self::situacoes(
            array_keys(SituacaoGeral::isHabilitado()),
            SituacaoGeral::modulo()
        );
    }

    public static function tipos(array $codigos, string $modulo): array
    {
        return array_values(array_map(
            fn(array $item) => [
                'ID_TIPO' => $item['ID_TIPO'],
                'CODIGO' => $item['CODIGO'],
                'DESCRICAO' => $item['DESCRICAO'],
            ],
            array_filter(
                TipoRegistro::dadosBanco(),
                fn(array $item) => $item['MODULO'] === $modulo
                    && in_array($item['CODIGO'], $codigos, true)
            )
        ));
    }

    public static function tiposPorModulo(string $modulo): array
    {
        return array_values(array_map(
            fn(array $item) => [
                'ID_TIPO' => $item['ID_TIPO'],
                'CODIGO' => $item['CODIGO'],
                'DESCRICAO' => $item['DESCRICAO'],
            ],
            array_filter(
                TipoRegistro::dadosBanco(),
                fn(array $item) => $item['MODULO'] === $modulo
            )
        ));
    }

    public static function tiposEndereco(): array
    {
        return self::tipos(
            array_keys(TipoEndereco::isEmpresa()),
            TipoEndereco::modulo()
        );
    }
}
