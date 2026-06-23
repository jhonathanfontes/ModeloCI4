<?php

namespace App\Modulos\Planos\DTO;

class PlanoDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $nome = null,
        public readonly ?string $descricao = null,
        public readonly ?string $valor = null,
        public readonly ?int $periodoId = null,
        public readonly ?string $periodoDescricao = null,
        public readonly ?int $limiteClientes = null,
        public readonly ?int $limiteUsuarios = null,
        public readonly ?int $limiteArmazenamentoMb = null,
        public readonly ?bool $situacao = null,
        public readonly ?array $modulos = null,
        public readonly ?array $servicos = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_PLANO,
            uuid: $row->UUID ?? null,
            nome: $row->NOME,
            descricao: $row->DESCRICAO ?? null,
            valor: $row->VALOR,
            periodoId: isset($row->PERIODO_ID) ? (int) $row->PERIODO_ID : null,
            periodoDescricao: $row->PERIODO_DESCRICAO ?? null,
            limiteClientes: $row->LIMITE_CLIENTES ?? null,
            limiteUsuarios: $row->LIMITE_USUARIOS ?? null,
            limiteArmazenamentoMb: $row->LIMITE_ARMAZENAMENTO_MB ?? null,
            situacao: isset($row->SITUACAO) ? (bool) $row->SITUACAO : null,
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
            'valor' => $this->valor,
            'periodo_id' => $this->periodoId,
            'periodo_descricao' => $this->periodoDescricao,
            'limite_clientes' => $this->limiteClientes,
            'limite_usuarios' => $this->limiteUsuarios,
            'limite_armazenamento_mb' => $this->limiteArmazenamentoMb,
            'situacao' => $this->situacao,
            'modulos' => $this->modulos,
            'servicos' => $this->servicos,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn ($v) => $v !== null);
    }
}
