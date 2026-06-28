<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use App\Traits\UuidModelTrait;
use CodeIgniter\Model;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 * @method \stdClass|null find($id = null)
 */
class EmpresaEnderecoModel extends Model
{
    use UuidModelTrait;

    protected $table = 'EMPR_ENDERECOS';
    protected $primaryKey = 'ID_ENDERECO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'TIPO_ID',
        'CEP',
        'LOGRADOURO',
        'NUMERO',
        'COMPLEMENTO',
        'BAIRRO',
        'CIDADE',
        'UF',
        'PRINCIPAL',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('EMPR_ENDERECOS_' . microtime());
        }

        return $data;
    }

    public function daEmpresa(int $empresaId): EmpresaEnderecoModel
    {
        return $this->where('EMPRESA_ID', $empresaId);
    }
}
