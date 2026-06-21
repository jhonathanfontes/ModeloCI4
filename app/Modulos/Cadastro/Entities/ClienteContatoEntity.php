<?php

namespace App\Modulos\Cadastro\Entities;

use CodeIgniter\Entity\Entity;

class ClienteContatoEntity extends Entity
{
    protected $casts = [
        'ID_CONTATO'  => 'integer',
        'CLIENTE_ID'  => 'integer',
        'PRINCIPAL'   => 'boolean',
        'CRIADO_POR'  => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id'         => 'ID_CONTATO',
        'uuid'       => 'UUID',
        'clienteId'  => 'CLIENTE_ID',
        'nome'       => 'NOME',
        'cargo'      => 'CARGO',
        'telefone'   => 'TELEFONE',
        'email'      => 'EMAIL',
        'whatsapp'   => 'WHATSAPP',
        'principal'  => 'PRINCIPAL',
    ];
}
