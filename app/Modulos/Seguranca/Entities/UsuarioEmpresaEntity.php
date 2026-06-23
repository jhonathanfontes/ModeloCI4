<?php

namespace App\Modulos\Seguranca\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioEmpresaEntity extends Entity
{
    protected $casts = [
        'ID_USUARIO_EMPRESA' => 'integer',
        'USUARIO_ID' => 'integer',
        'EMPRESA_ID' => 'integer',
        'PERFIL_ID' => '?integer',
        'SITUACAO_ID' => 'integer',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_USUARIO_EMPRESA',
        'uuid' => 'UUID',
        'usuarioId' => 'USUARIO_ID',
        'empresaId' => 'EMPRESA_ID',
        'perfilId' => 'PERFIL_ID',
        'situacaoId' => 'SITUACAO_ID',
    ];
}
