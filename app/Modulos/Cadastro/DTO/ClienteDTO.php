<?php

namespace App\Modulos\Cadastro\DTO;

class ClienteDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?int $empresaId = null,
        public readonly ?string $nome = null,
        public readonly ?string $nomeFantasia = null,
        public readonly ?int $tipoId = null,
        public readonly ?string $tipoNome = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $situacaoDescricao = null,
        public readonly ?string $empresaNome = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {}

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_CLIENTE,
            uuid: $row->UUID ?? null,
            empresaId: (int) $row->EMPRESA_ID,
            nome: $row->NOME,
            nomeFantasia: $row->NOME_FANTASIA ?? null,
            tipoId: (int) $row->TIPO_ID,
            tipoNome: $row->TIPO_NOME ?? null,
            situacaoId: (int) $row->SITUACAO_ID,
            situacaoCodigo: $row->SITUACAO_CODIGO ?? null,
            situacaoCor: $row->SITUACAO_COR ?? null,
            situacaoDescricao: $row->SITUACAO_DESCRICAO ?? null,
            empresaNome: $row->EMPRESA_NOME ?? null,
            criadoEm: $row->CRIADO_EM ?? null,
            atualizadoEm: $row->ATUALIZADO_EM ?? null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            uuid: $data['uuid'] ?? null,
            empresaId: $data['empresa_id'] ?? null,
            nome: $data['nome'] ?? null,
            nomeFantasia: $data['nome_fantasia'] ?? null,
            tipoId: $data['tipo_id'] ?? null,
            situacaoId: $data['situacao_id'] ?? null,
            criadoEm: $data['criado_em'] ?? null,
            atualizadoEm: $data['atualizado_em'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'empresa_id' => $this->empresaId,
            'nome' => $this->nome,
            'nome_fantasia' => $this->nomeFantasia,
            'tipo_id' => $this->tipoId,
            'tipo_nome' => $this->tipoNome,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'empresa_nome' => $this->empresaNome,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn($v) => $v !== null);
    }
}
