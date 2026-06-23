<?php

namespace App\Modulos\Cadastro\Entities;

use CodeIgniter\Entity\Entity;

class EmpresaEntity extends Entity
{
    protected $casts = [
        'ID_EMPRESA' => 'integer',
        'SITUACAO_ID' => 'integer',
        'CRIADO_POR' => '?integer',
        'ATUALIZADO_POR' => '?integer',
        'EXCLUIDO_POR' => '?integer',
    ];

    protected $datamap = [
        'id' => 'ID_EMPRESA',
        'uuid' => 'UUID',
        'razaoSocial' => 'RAZAO_SOCIAL',
        'nomeFantasia' => 'NOME_FANTASIA',
        'cpfCnpj' => 'CPF_CNPJ',
        'email' => 'EMAIL',
        'telefone' => 'TELEFONE',
        'celular' => 'CELULAR',
        'situacaoId' => 'SITUACAO_ID',
    ];
}
