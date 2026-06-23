<?php

namespace App\Modulos\Seguranca\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class UsuarioEmpresaModel extends Model
{
    protected $table = 'USUA_USUARIO_EMPRESAS';
    protected $primaryKey = 'ID_USUARIO_EMPRESA';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'USUARIO_ID',
        'EMPRESA_ID',
        'PERFIL_ID',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'max_length[36]',
        'USUARIO_ID' => 'required|integer',
        'EMPRESA_ID' => 'required|integer',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('USUA_USUARIO_EMPRESAS_' . microtime());
        }

        return $data;
    }

    public function vinculoAtivo(int $usuarioId, int $empresaId): ?object
    {
        return $this->where('USUARIO_ID', $usuarioId)
            ->where('EMPRESA_ID', $empresaId)
            ->first();
    }
}
