<?php

namespace App\Modulos\Cadastro\Entities;

use App\Dominios\SituacaoRegistro;
use CodeIgniter\Entity\Entity;

class ClienteEntity extends Entity
{
    protected $casts = [
        'ID_CLIENTE'   => 'integer',
        'EMPRESA_ID'   => 'integer',
        'PESSOA_ID'    => '?integer',
        'TIPO_ID'      => 'integer',
        'SITUACAO_ID'  => 'integer',
        'CRIADO_POR'   => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id'         => 'ID_CLIENTE',
        'uuid'       => 'UUID',
        'empresaId'  => 'EMPRESA_ID',
        'pessoaId'   => 'PESSOA_ID',
        'nome'       => 'NOME',
        'nomeFantasia' => 'NOME_FANTASIA',
        'tipoId'     => 'TIPO_ID',
        'situacaoId' => 'SITUACAO_ID',
    ];

    public function isAtivo(): bool
    {
        return $this->attributes['SITUACAO_ID'] === service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );
    }

    public function isCancelado(): bool
    {
        return $this->attributes['SITUACAO_ID'] === service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );
    }
}
