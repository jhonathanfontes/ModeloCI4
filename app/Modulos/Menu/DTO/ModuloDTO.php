<?php

namespace App\Modulos\Menu\DTO;

class ModuloDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $nome = null,
        public readonly ?string $descricao = null,
        public readonly ?string $icone = null,
        public readonly ?string $urlRota = null,
        public readonly ?int $ordem = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $situacaoDescricao = null,
        public readonly ?array $servicos = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {}

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_MODULO,
            uuid: $row->UUID ?? null,
            nome: $row->NOME,
            descricao: $row->DESCRICAO ?? null,
            icone: $row->ICONE ?? null,
            urlRota: $row->URL_ROTA ?? null,
            ordem: $row->ORDEM ?? null,
            situacaoId: (int) $row->SITUACAO_ID,
            situacaoCodigo: $row->SITUACAO_CODIGO ?? null,
            situacaoCor: $row->SITUACAO_COR ?? null,
            situacaoDescricao: $row->SITUACAO_DESCRICAO ?? null,
            criadoEm: $row->CRIADO_EM ?? null,
            atualizadoEm: $row->ATUALIZADO_EM ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
            'url_rota' => $this->urlRota,
            'ordem' => $this->ordem,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'servicos' => $this->servicos,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn($v) => $v !== null);
    }
}
