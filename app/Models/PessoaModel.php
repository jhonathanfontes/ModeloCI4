<?php

namespace App\Models;

use CodeIgniter\Model;

class PessoaModel extends Model
{
    protected $table = 'PESSOAS';
    protected $primaryKey = 'ID_PESSOA';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'CPF_CNPJ',
        'DATA_NASCIMENTO',
        'SITUACAO_ID',
        'CRIADO_POR',
        'ATUALIZADO_POR',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'CPF_CNPJ' => 'required|max_length[14]',
    ];

    public function findByCpfCnpj(string $cpfCnpj): ?object
    {
        return $this->where('CPF_CNPJ', $cpfCnpj)->first();
    }
}
