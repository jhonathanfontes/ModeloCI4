<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class ClienteUsuarioModel extends Model
{
    use UuidModelTrait;
    protected $table = 'CLIE_USUARIO';
    protected $primaryKey = 'ID_CLIE_USUARIO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'PESSOA_ID',
        'CLIENTE_ID',
        'NOME',
        'EMAIL',
        'SENHA_HASH',
        'TELEFONE',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'PESSOA_ID' => 'required|integer',
        'NOME' => 'required|max_length[255]',
        'EMAIL' => 'required|valid_email|max_length[255]|is_unique[CLIE_USUARIO.EMAIL]',
        'SENHA_HASH' => 'required|max_length[255]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('CLIE_USUARIO_' . microtime());
        }

        return $data;
    }

    public function findByEmail(string $email): ?object
    {
        return $this->where('EMAIL', $email)->first();
    }
}
