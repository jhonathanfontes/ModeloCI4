<?php

namespace App\Modulos\Planos\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class PlanoModel extends Model
{
    use UuidModelTrait;
    protected $table = 'SIST_PLANOS';
    protected $primaryKey = 'ID_PLANO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'NOME',
        'DESCRICAO',
        'VALOR',
        'PERIODO_ID',
        'LIMITE_CLIENTES',
        'LIMITE_USUARIOS',
        'LIMITE_ARMAZENAMENTO_MB',
        'SITUACAO',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'NOME' => 'required|max_length[100]',
        'VALOR' => 'required|decimal',
        'PERIODO_ID' => 'permit_empty|max_length[50]',
        'LIMITE_CLIENTES' => 'permit_empty|integer',
        'LIMITE_USUARIOS' => 'permit_empty|integer',
        'LIMITE_ARMAZENAMENTO_MB' => 'permit_empty|integer',
        'SITUACAO' => 'permit_empty|in_list[0,1]',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('SIST_PLANOS_' . microtime());
        }

        return $data;
    }

    public function comPeriodo(): PlanoModel
    {
        return $this->select('SIST_PLANOS.*, SIST_TIPOS.DESCRICAO AS PERIODO_DESCRICAO')
            ->join('SIST_TIPOS', 'SIST_TIPOS.ID_TIPO = SIST_PLANOS.PERIODO_ID', 'left');
    }
}
