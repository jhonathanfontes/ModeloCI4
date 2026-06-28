<?php

namespace App\Modulos\Sistema\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

/**
 * @method \stdClass|null first(...$params)
 * @method \stdClass[]    findAll(...$params)
 * @method \stdClass|null findByUuid(string $uuid)
 */
class TipoModel extends Model
{
    protected $table = 'SIST_TIPOS';
    protected $primaryKey = 'ID_TIPO';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'ID_TIPO',
        'UUID',
        'MODULO',
        'CODIGO',
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
        'MODULO' => 'required|max_length[100]',
        'CODIGO' => 'required|max_length[50]',
        'DESCRICAO' => 'required|max_length[255]',
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
