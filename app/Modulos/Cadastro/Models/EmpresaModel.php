<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'EMPRESAS';
    protected $primaryKey = 'ID_EMPRESA';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'RAZAO_SOCIAL',
        'NOME_FANTASIA',
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
        'RAZAO_SOCIAL' => 'required|max_length[255]',
        'NOME_FANTASIA' => 'required|max_length[255]',
        'CPF_CNPJ' => 'required|min_length[11]|max_length[14]',
        'EMAIL' => 'required|valid_email|max_length[255]',
        'TELEFONE' => 'permit_empty|max_length[15]',
        'CELULAR' => 'permit_empty|max_length[15]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('EMPRESAS_' . microtime());
        }

        return $data;
    }

    public function comSituacao(): EmpresaModel
    {
        return $this->select('EMPRESAS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = EMPRESAS.SITUACAO_ID', 'left');
    }
}
