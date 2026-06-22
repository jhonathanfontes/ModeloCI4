<?php

namespace App\Modulos\Menu\DTO;

class FuncionalidadeDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?int $servicoId = null,
        public readonly ?string $servicoNome = null,
        public readonly ?string $nome = null,
        public readonly ?string $descricao = null,
        public readonly ?string $chave = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $situacaoDescricao = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {}

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_FUNCIONALIDADE,
            uuid: $row->UUID ?? null,
            servicoId: (int) $row->SERVICO_ID,
            servicoNome: $row->SERVICO_NOME ?? null,
            nome: $row->NOME,
            descricao: $row->DESCRICAO ?? null,
            chave: $row->CHAVE,
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
            'servico_id' => $this->servicoId,
            'servico_nome' => $this->servicoNome,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'chave' => $this->chave,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn($v) => $v !== null);
    }
}
