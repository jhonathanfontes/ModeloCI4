<?php

namespace App\Modulos\Sistema\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class TipoModel extends Model
{
    protected $table = 'SIST_TIPOS';
    protected $primaryKey = 'ID_TIPO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'MODULO_ID',
        'CODIGO',
        'NOME',
        'DESCRICAO',
        'ORDEM',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'CODIGO' => 'required|max_length[50]',
        'NOME' => 'required|max_length[100]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('SIST_TIPOS_' . microtime());
        }

        return $data;
    }
}
