<?php

namespace App\Modulos\Planos\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class PlanoServicoModel extends Model
{
    use UuidModelTrait;
    protected $table = 'SIST_PLANO_SERVICOS';
    protected $primaryKey = 'ID_PLANO_SERVICO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'UUID',
        'PLANO_ID',
        'SERVICO_ID',
        'SITUACAO',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'PLANO_ID' => 'required|integer',
        'SERVICO_ID' => 'required|integer',
        'SITUACAO' => 'permit_empty|in_list[0,1]',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('PLANO_SERVICOS_' . microtime());
        }

        return $data;
    }
}
