<?php

namespace App\Modulos\Seguranca\DTO;

class UsuarioDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?string $nome = null,
        public readonly ?string $email = null,
        public readonly ?string $tipo = null,
        public readonly ?string $ultimoLogin = null,
        public readonly ?int $tentativasLogin = null,
        public readonly ?int $situacaoId = null,
        public readonly ?string $situacaoCodigo = null,
        public readonly ?string $situacaoCor = null,
        public readonly ?string $situacaoDescricao = null,
        public readonly ?array $empresas = null,
        public readonly ?string $criadoEm = null,
        public readonly ?string $atualizadoEm = null,
    ) {
    }

    public static function fromObject(object $row): self
    {
        return new self(
            id: (int) $row->ID_USUARIO,
            uuid: $row->UUID ?? null,
            nome: $row->NOME,
            email: $row->EMAIL,
            tipo: $row->TIPO ?? null,
            ultimoLogin: $row->ULTIMO_LOGIN ?? null,
            tentativasLogin: $row->TENTATIVAS_LOGIN ?? null,
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
            'email' => $this->email,
            'tipo' => $this->tipo,
            'ultimo_login' => $this->ultimoLogin,
            'tentativas_login' => $this->tentativasLogin,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'empresas' => $this->empresas,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn ($v) => $v !== null);
    }
}
