<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class ClienteContatoModel extends Model
{
    protected $table            = 'CLIE_CONTATOS';
    protected $primaryKey       = 'ID_CONTATO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'UUID',
        'CLIENTE_ID',
        'NOME',
        'CARGO',
        'TELEFONE',
        'EMAIL',
        'WHATSAPP',
        'PRINCIPAL',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CRIADO_EM';
    protected $updatedField  = 'ATUALIZADO_EM';
    protected $deletedField  = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'       => 'required|max_length[36]',
        'CLIENTE_ID' => 'required|integer',
        'NOME'       => 'required|max_length[150]',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (!isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('CLIE_CONTATOS_' . microtime());
        }
        return $data;
    }

    public function principaisDoCliente(int $clienteId): array
    {
        return $this->where('CLIENTE_ID', $clienteId)
            ->where('PRINCIPAL', 1)
            ->findAll();
    }
}
