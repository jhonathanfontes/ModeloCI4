<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class EmpresaModuloModel extends Model
{
    protected $table = 'EMPR_EMPRESA_MODULOS';
    protected $primaryKey = 'ID_EMPRESA_MODULO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'MODULO_ID',
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
        'MODULO_ID' => 'required|integer',
        'ATIVO' => 'permit_empty|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('EMPR_MODULOS_' . microtime());
        }

        return $data;
    }

    public function comModulo(): EmpresaModuloModel
    {
        return $this->select('EMPR_EMPRESA_MODULOS.*, MENU_MODULOS.NOME AS MODULO_NOME, MENU_MODULOS.ICONE AS MODULO_ICONE')
            ->join('MENU_MODULOS', 'MENU_MODULOS.ID_MODULO = EMPR_EMPRESA_MODULOS.MODULO_ID', 'left');
    }
}
