<?php

namespace App\Modulos\Cadastro\DTO;

class EmpresaDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $razaoSocial = null,
        public readonly ?string $nomeFantasia = null,
        public readonly ?string $cpfCnpj = null,
        public readonly ?string $email = null,
        public readonly ?string $telefone = null,
        public readonly ?string $celular = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $situacaoDescricao = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_EMPRESA,
            uuid: $row->UUID ?? null,
            razaoSocial: $row->RAZAO_SOCIAL,
            nomeFantasia: $row->NOME_FANTASIA,
            cpfCnpj: $row->CPF_CNPJ ?? null,
            email: $row->EMAIL,
            telefone: $row->TELEFONE ?? null,
            celular: $row->CELULAR ?? null,
            situacaoId: $row->SITUACAO_ID,
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
            'razao_social' => $this->razaoSocial,
            'nome_fantasia' => $this->nomeFantasia,
            'cpf_cnpj' => $this->cpfCnpj,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'celular' => $this->celular,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn ($v) => $v !== null);
    }
}
