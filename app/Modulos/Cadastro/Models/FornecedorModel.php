<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class FornecedorModel extends Model
{
    protected $table = 'FORNECEDORES';
    protected $primaryKey = 'ID_FORNECEDOR';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'NOME',
        'CPF_CNPJ',
        'EMAIL',
        'TELEFONE',
        'CELULAR',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'EMPRESA_ID' => 'required|integer',
        'NOME' => 'required|max_length[255]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('FORNECEDORES_' . microtime());
        }

        return $data;
    }

    public function comEmpresa(): FornecedorModel
    {
        return $this->select('FORNECEDORES.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = FORNECEDORES.EMPRESA_ID', 'left');
    }

    public function comSituacao(): FornecedorModel
    {
        return $this->select('FORNECEDORES.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = FORNECEDORES.SITUACAO_ID', 'left');
    }
}
