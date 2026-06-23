<?php

namespace App\Modulos\Seguranca\Entities;

use CodeIgniter\Entity\Entity;

class PerfilEntity extends Entity
{
    protected $casts = [
        'ID_PERFIL' => 'integer',
        'NIVEL' => '?integer',
        'SITUACAO_ID' => 'integer',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_PERFIL',
        'uuid' => 'UUID',
        'nome' => 'NOME',
        'descricao' => 'DESCRICAO',
        'nivel' => 'NIVEL',
        'situacaoId' => 'SITUACAO_ID',
    ];
}
