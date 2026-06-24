<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'PRODUTOS';
    protected $primaryKey = 'ID_PRODUTO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'NOME',
        'DESCRICAO',
        'PRECO_CUSTO',
        'PRECO_VENDA',
        'UNIDADE',
        'CODIGO_BARRAS',
        'CODIGO_INTERNO',
        'ESTOQUE',
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
            $data['data']['UUID'] = Uuid::generate('PRODUTOS_' . microtime());
        }

        return $data;
    }

    public function comEmpresa(): ProdutoModel
    {
        return $this->select('PRODUTOS.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = PRODUTOS.EMPRESA_ID', 'left');
    }

    public function comSituacao(): ProdutoModel
    {
        return $this->select('PRODUTOS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = PRODUTOS.SITUACAO_ID', 'left');
    }
}
