<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class EmpresaLicencaModel extends Model
{
    use UuidModelTrait;
    protected $table = 'EMPR_LICENCAS';
    protected $primaryKey = 'ID_LICENCA';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'PLANO_ID',
        'DATA_INICIO',
        'DATA_FIM',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'EMPRESA_ID' => 'required|integer',
        'PLANO_ID' => 'required|integer',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('EMPR_LICENCAS_' . microtime());
        }

        return $data;
    }

    public function comPlano(): EmpresaLicencaModel
    {
        return $this->select('EMPR_LICENCAS.*, SIST_PLANOS.NOME AS PLANO_NOME')
            ->join('SIST_PLANOS', 'SIST_PLANOS.ID_PLANO = EMPR_LICENCAS.PLANO_ID', 'left');
    }
}
