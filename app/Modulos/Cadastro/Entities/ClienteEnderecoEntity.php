<?php

namespace App\Modulos\Cadastro\Entities;

use CodeIgniter\Entity\Entity;

class ClienteEnderecoEntity extends Entity
{
    protected $casts = [
        'ID_ENDERECO' => 'integer',
        'CLIENTE_ID' => 'integer',
        'TIPO_ID' => 'integer',
        'PRINCIPAL' => 'boolean',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_ENDERECO',
        'uuid' => 'UUID',
        'clienteId' => 'CLIENTE_ID',
        'tipoId' => 'TIPO_ID',
        'cep' => 'CEP',
        'logradouro' => 'LOGRADOURO',
        'numero' => 'NUMERO',
        'complemento' => 'COMPLEMENTO',
        'bairro' => 'BAIRRO',
        'cidade' => 'CIDADE',
        'uf' => 'UF',
        'principal' => 'PRINCIPAL',
    ];
}
