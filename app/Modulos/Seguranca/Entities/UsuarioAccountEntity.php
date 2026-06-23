<?php

namespace App\Modulos\Seguranca\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioAccountEntity extends Entity
{
    protected $casts = [
        'ID_ACCOUNT' => 'integer',
        'USUARIO_ID' => 'integer',
        'TENTATIVAS_FALHAS' => 'integer',
        'SITUACAO_ID' => 'integer',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_ACCOUNT',
        'uuid' => 'UUID',
        'usuarioId' => 'USUARIO_ID',
        'username' => 'USERNAME',
        'email' => 'EMAIL',
        'senhaHash' => 'SENHA_HASH',
        'ultimoLogin' => 'ULTIMO_LOGIN',
        'tentativasFalhas' => 'TENTATIVAS_FALHAS',
        'bloqueadoEm' => 'BLOQUEADO_EM',
        'situacaoId' => 'SITUACAO_ID',
    ];

    protected $hidden = [
        'SENHA_HASH',
    ];
}
