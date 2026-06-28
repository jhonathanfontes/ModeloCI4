<?php

namespace App\Modulos\Cadastro\DTO;

/**
 * @property-read ?int $ID_CLIENTE
 * @property-read ?string $UUID
 * @property-read ?int $EMPRESA_ID
 * @property-read ?int $PESSOA_ID
 * @property-read ?string $CPF_CNPJ
 * @property-read ?string $DATA_NASCIMENTO
 * @property-read ?string $NOME
 * @property-read ?string $NOME_FANTASIA
 * @property-read ?int $TIPO_ID
 * @property-read ?string $TIPO_NOME
 * @property-read ?string $TIPO_DESCRICAO
 * @property-read ?int $SITUACAO_ID
 * @property-read ?string $SITUACAO_CODIGO
 * @property-read ?string $SITUACAO_COR
 * @property-read ?string $SITUACAO_DESCRICAO
 * @property-read ?string $EMPRESA_NOME
 * @property-read ?string $CRIADO_EM
 * @property-read ?string $ATUALIZADO_EM
 */
class ClienteDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?int $empresaId = null,
        public readonly ?int $pessoaId = null,
        public readonly ?string $cpfCnpj = null,
        public readonly ?string $dataNascimento = null,
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
    ) {
    }

    public function __get(string $name)
    {
        return match ($name) {
            'ID_CLIENTE' => $this->id,
            'UUID' => $this->uuid,
            'EMPRESA_ID' => $this->empresaId,
            'PESSOA_ID' => $this->pessoaId,
            'CPF_CNPJ' => $this->cpfCnpj,
            'DATA_NASCIMENTO' => $this->dataNascimento,
            'NOME' => $this->nome,
            'NOME_FANTASIA' => $this->nomeFantasia,
            'TIPO_ID' => $this->tipoId,
            'TIPO_NOME', 'TIPO_DESCRICAO' => $this->tipoNome,
            'SITUACAO_ID' => $this->situacaoId,
            'SITUACAO_CODIGO' => $this->situacaoCodigo,
            'SITUACAO_COR' => $this->situacaoCor,
            'SITUACAO_DESCRICAO' => $this->situacaoDescricao,
            'EMPRESA_NOME' => $this->empresaNome,
            'CRIADO_EM' => $this->criadoEm,
            'ATUALIZADO_EM' => $this->atualizadoEm,
            default => null,
        };
    }

    public function __isset(string $name): bool
    {
        return in_array($name, [
            'ID_CLIENTE', 'UUID', 'EMPRESA_ID', 'PESSOA_ID', 'CPF_CNPJ',
            'DATA_NASCIMENTO', 'NOME', 'NOME_FANTASIA', 'TIPO_ID',
            'TIPO_NOME', 'TIPO_DESCRICAO', 'SITUACAO_ID', 'SITUACAO_CODIGO',
            'SITUACAO_COR', 'SITUACAO_DESCRICAO', 'EMPRESA_NOME',
            'CRIADO_EM', 'ATUALIZADO_EM',
        ], true) && $this->__get($name) !== null;
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_CLIENTE,
            uuid: $row->UUID ?? null,
            empresaId: (int) $row->EMPRESA_ID,
            pessoaId: isset($row->PESSOA_ID) ? (int) $row->PESSOA_ID : null,
            cpfCnpj: $row->CPF_CNPJ ?? null,
            dataNascimento: $row->DATA_NASCIMENTO ?? null,
            nome: $row->NOME,
            nomeFantasia: $row->NOME_FANTASIA ?? null,
            tipoId: (int) $row->TIPO_ID,
            tipoNome: $row->TIPO_NOME ?? null,
            situacaoId: $row->SITUACAO_ID,
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
        ], fn ($v) => $v !== null);
    }
}
