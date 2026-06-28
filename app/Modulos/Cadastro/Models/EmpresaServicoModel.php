<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class EmpresaServicoModel extends Model
{
    use UuidModelTrait;
    protected $table = 'EMPR_EMPRESA_SERVICOS';
    protected $primaryKey = 'ID_EMPRESA_SERVICO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'SERVICO_ID',
        'ATIVO',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'EMPRESA_ID' => 'required|integer',
        'SERVICO_ID' => 'required|integer',
        'ATIVO' => 'permit_empty|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('EMPR_SERVICOS_' . microtime());
        }

        return $data;
    }

    public function comServico(): EmpresaServicoModel
    {
        return $this->select('EMPR_EMPRESA_SERVICOS.*, MENU_SERVICOS.NOME AS SERVICO_NOME, MENU_SERVICOS.ICONE AS SERVICO_ICONE, MENU_SERVICOS.MODULO_ID')
            ->join('MENU_SERVICOS', 'MENU_SERVICOS.ID_SERVICO = EMPR_EMPRESA_SERVICOS.SERVICO_ID', 'left');
    }
}
