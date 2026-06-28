<?php

namespace App\Modulos\Menu\DTO;

class ServicoDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $uuid = null,
        public readonly ?int $moduloId = null,
        public readonly ?string $moduloNome = null,
        public readonly ?string $nome = null,
        public readonly ?string $descricao = null,
        public readonly ?string $urlModulo = null,
        public readonly ?string $urlRota = null,
        public readonly ?string $icone = null,
        public readonly ?int $ordem = null,
        public readonly ?bool $dashboard = null,
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
            id: (int) $row->ID_SERVICO,
            uuid: $row->UUID ?? null,
            moduloId: (int) $row->MODULO_ID,
            moduloNome: $row->MODULO_NOME ?? null,
            nome: $row->NOME,
            descricao: $row->DESCRICAO ?? null,
            urlModulo: $row->URL_MODULO ?? null,
            urlRota: $row->URL_ROTA ?? null,
            icone: $row->ICONE ?? null,
            ordem: $row->ORDEM ?? null,
            dashboard: isset($row->DASHBOARD) ? (bool) $row->DASHBOARD : null,
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
            'modulo_id' => $this->moduloId,
            'modulo_nome' => $this->moduloNome,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'url_modulo' => $this->urlModulo,
            'url_rota' => $this->urlRota,
            'icone' => $this->icone,
            'ordem' => $this->ordem,
            'dashboard' => $this->dashboard,
            'situacao_id' => $this->situacaoId,
            'situacao_codigo' => $this->situacaoCodigo,
            'situacao_cor' => $this->situacaoCor,
            'situacao_descricao' => $this->situacaoDescricao,
            'criado_em' => $this->criadoEm,
            'atualizado_em' => $this->atualizadoEm,
        ], fn ($v) => $v !== null);
    }
}
