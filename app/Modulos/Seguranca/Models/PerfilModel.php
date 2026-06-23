<?php

namespace App\Modulos\Seguranca\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $table = 'PERF_PERFIS';
    protected $primaryKey = 'ID_PERFIL';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'NOME',
        'DESCRICAO',
        'NIVEL',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'NOME' => 'required|max_length[100]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('PERF_PERFIS_' . microtime());
        }

        return $data;
    }
}
