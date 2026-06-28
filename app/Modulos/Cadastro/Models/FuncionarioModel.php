<?php

namespace App\Modulos\Cadastro\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;
use App\Traits\UuidModelTrait;

/**
 * @method \stdClass|null findByUuid(string $uuid)
 */
class FuncionarioModel extends Model
{
    use UuidModelTrait;
    protected $table = 'FUNCIONARIOS';
    protected $primaryKey = 'ID_FUNCIONARIO';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'EMPRESA_ID',
        'NOME',
        'EMAIL',
        'CARGO',
        'TIPO_ID',
        'DEPARTAMENTO_ID',
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
        'EMPRESA_ID' => 'required|integer',
        'NOME' => 'required|max_length[255]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('FUNCIONARIOS_' . microtime());
        }

        return $data;
    }

    public function comEmpresa(): FuncionarioModel
    {
        return $this->select('FUNCIONARIOS.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = FUNCIONARIOS.EMPRESA_ID', 'left');
    }

    public function comSituacao(): FuncionarioModel
    {
        return $this->select('FUNCIONARIOS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = FUNCIONARIOS.SITUACAO_ID', 'left');
    }
}
