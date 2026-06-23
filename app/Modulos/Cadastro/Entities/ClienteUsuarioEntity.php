<?php

namespace App\Modulos\Cadastro\Entities;

use CodeIgniter\Entity\Entity;

class ClienteUsuarioEntity extends Entity
{
    protected $casts = [
        'ID_CLIE_USUARIO' => 'integer',
        'PESSOA_ID' => 'integer',
        'CLIENTE_ID' => '?integer',
        'SITUACAO_ID' => 'integer',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_CLIE_USUARIO',
        'uuid' => 'UUID',
        'pessoaId' => 'PESSOA_ID',
        'clienteId' => 'CLIENTE_ID',
        'nome' => 'NOME',
        'email' => 'EMAIL',
        'senhaHash' => 'SENHA_HASH',
        'telefone' => 'TELEFONE',
        'situacaoId' => 'SITUACAO_ID',
    ];

    protected $hidden = [
        'SENHA_HASH',
    ];
}
