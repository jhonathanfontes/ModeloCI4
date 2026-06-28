<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use App\Traits\UuidModelTrait;
use CodeIgniter\Model;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 * @method \stdClass|null find($id = null)
 */
class EmpresaContatoModel extends Model
{
    use UuidModelTrait;

    protected $table = 'EMPR_CONTATOS';
    protected $primaryKey = 'ID_CONTATO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'NOME',
        'CARGO',
        'TIPO_ID',
        'TELEFONE',
        'EMAIL',
        'WHATSAPP',
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
            $data['data']['UUID'] = Uuid::generate('EMPR_CONTATOS_' . microtime());
        }

        return $data;
    }

    public function daEmpresa(int $empresaId): EmpresaContatoModel
    {
        return $this->where('EMPRESA_ID', $empresaId);
    }
}
