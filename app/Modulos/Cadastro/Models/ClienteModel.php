<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class ClienteModel extends Model
{
    use UuidModelTrait;
    protected $table = 'CLIENTES';
    protected $primaryKey = 'ID_CLIENTE';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'PESSOA_ID',
        'NOME',
        'NOME_FANTASIA',
        'TIPO_ID',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'permit_empty|max_length[36]',
        'EMPRESA_ID' => 'required|integer',
        'NOME' => 'required|max_length[255]',
        'TIPO_ID' => 'required|integer',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('CLIENTES_' . microtime());
        }

        return $data;
    }

    public function comEmpresa(): ClienteModel
    {
        return $this->select('CLIENTES.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = CLIENTES.EMPRESA_ID', 'left');
    }

    public function comPessoa(): ClienteModel
    {
        return $this->select('CLIENTES.*, PESSOAS.CPF_CNPJ, PESSOAS.DATA_NASCIMENTO')
            ->join('PESSOAS', 'PESSOAS.ID_PESSOA = CLIENTES.PESSOA_ID', 'left');
    }

    public function comSituacao(): ClienteModel
    {
        return $this->select('CLIENTES.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = CLIENTES.SITUACAO_ID', 'left');
    }

    public function comTipo(): ClienteModel
    {
        return $this->select('CLIENTES.*, SIST_TIPOS.DESCRICAO AS TIPO_NOME')
            ->join('SIST_TIPOS', 'SIST_TIPOS.ID_TIPO = CLIENTES.TIPO_ID', 'left');
    }
}
