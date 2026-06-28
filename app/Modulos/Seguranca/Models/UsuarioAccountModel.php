<?php

namespace App\Modulos\Seguranca\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class UsuarioAccountModel extends Model
{
    use UuidModelTrait;
    protected $table = 'SEGU_ACCOUNTS';
    protected $primaryKey = 'ID_ACCOUNT';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'USUARIO_ID',
        'USERNAME',
        'EMAIL',
        'SENHA_HASH',
        'ULTIMO_LOGIN',
        'TENTATIVAS_FALHAS',
        'BLOQUEADO_EM',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'USUARIO_ID' => 'required|integer',
        'EMAIL' => 'required|valid_email|max_length[255]|is_unique[SEGU_ACCOUNTS.EMAIL]',
        'SENHA_HASH' => 'required|max_length[255]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('SEGU_ACCOUNTS_' . microtime());
        }

        return $data;
    }

    public function findByEmail(string $email): ?object
    {
        return $this->where('EMAIL', $email)->first();
    }
}
