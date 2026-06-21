<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class ClienteEnderecoModel extends Model
{
    protected $table            = 'CLIE_ENDERECOS';
    protected $primaryKey       = 'ID_ENDERECO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'UUID',
        'CLIENTE_ID',
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
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CRIADO_EM';
    protected $updatedField  = 'ATUALIZADO_EM';
    protected $deletedField  = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'       => 'required|max_length[36]',
        'CLIENTE_ID' => 'required|integer',
        'TIPO_ID'    => 'required|integer',
        'CEP'        => 'required|exact_length[8]',
        'LOGRADOURO' => 'required|max_length[255]',
        'NUMERO'     => 'required|max_length[20]',
        'BAIRRO'     => 'required|max_length[120]',
        'CIDADE'     => 'required|max_length[120]',
        'UF'         => 'required|exact_length[2]',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (!isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('CLIE_ENDERECOS_' . microtime());
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
