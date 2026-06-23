<?php

namespace App\Modulos\Planos\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class PlanoModuloModel extends Model
{
    protected $table = 'SIST_PLANO_MODULOS';
    protected $primaryKey = 'ID_PLANO_MODULO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'UUID',
        'PLANO_ID',
        'MODULO_ID',
        'SITUACAO',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'PLANO_ID' => 'required|integer',
        'MODULO_ID' => 'required|integer',
        'SITUACAO' => 'permit_empty|in_list[0,1]',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('PLANO_MODULOS_' . microtime());
        }

        return $data;
    }
}
