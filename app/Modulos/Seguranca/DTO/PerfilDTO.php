<?php

namespace App\Modulos\Seguranca\DTO;

class PerfilDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $nome = null,
        public readonly ?string $descricao = null,
        public readonly ?int $nivel = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_PERFIL,
            uuid: $row->UUID ?? null,
            nome: $row->NOME,
            descricao: $row->DESCRICAO ?? null,
            nivel: $row->NIVEL ?? null,
            situacaoId: $row->SITUACAO_ID,
            situacaoCodigo: $row->SITUACAO_CODIGO ?? null,
            situacaoCor: $row->SITUACAO_COR ?? null,
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
            'nivel' => $this->nivel,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn ($v) => $v !== null);
    }
}
