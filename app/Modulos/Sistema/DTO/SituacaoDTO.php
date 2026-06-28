<?php

namespace App\Modulos\Sistema\DTO;

class SituacaoDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $modulo = null,
        public readonly ?string $codigo = null,
        public readonly ?string $descricao = null,
        public readonly ?string $cor = null,
        public readonly ?string $icone = null,
        public readonly ?bool $finalizado = null,
        public readonly ?bool $concluida = null,
        public readonly ?bool $cancelada = null,
        public readonly ?bool $pendente = null,
        public readonly ?bool $bloqueiaEdicao = null,
        public readonly ?bool $geraHistorico = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_SITUACAO,
            uuid: $row->UUID ?? null,
            modulo: $row->MODULO,
            codigo: $row->CODIGO,
            descricao: $row->DESCRICAO,
            cor: $row->COR ?? null,
            icone: $row->ICONE ?? null,
            finalizado: isset($row->FINALIZADO) ? (bool) $row->FINALIZADO : null,
            concluida: isset($row->CONCLUIDA) ? (bool) $row->CONCLUIDA : null,
            cancelada: isset($row->CANCELADA) ? (bool) $row->CANCELADA : null,
            pendente: isset($row->PENDENTE) ? (bool) $row->PENDENTE : null,
            bloqueiaEdicao: isset($row->BLOQUEIA_EDICAO) ? (bool) $row->BLOQUEIA_EDICAO : null,
            geraHistorico: isset($row->GERA_HISTORICO) ? (bool) $row->GERA_HISTORICO : null,
            criadoEm: $row->CRIADO_EM ?? null,
            atualizadoEm: $row->ATUALIZADO_EM ?? null,
        );
    }
}
