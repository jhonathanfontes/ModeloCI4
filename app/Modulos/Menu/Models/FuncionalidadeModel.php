<?php

namespace App\Modulos\Menu\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class FuncionalidadeModel extends Model
{
    protected $table = 'MENU_FUNCIONALIDADES';
    protected $primaryKey = 'ID_FUNCIONALIDADE';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'UUID',
        'SERVICO_ID',
        'NOME',
        'DESCRICAO',
        'CHAVE',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'SERVICO_ID' => 'required|integer',
        'NOME' => 'required|max_length[100]',
        'CHAVE' => 'required|max_length[100]',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('MENU_FUNCIONALIDADES_' . microtime());
        }

        return $data;
    }

    public function comServico(): FuncionalidadeModel
    {
        return $this->select('MENU_FUNCIONALIDADES.*, MENU_SERVICOS.NOME AS SERVICO_NOME')
            ->join('MENU_SERVICOS', 'MENU_SERVICOS.ID_SERVICO = MENU_FUNCIONALIDADES.SERVICO_ID', 'left');
    }

    public function comSituacao(): FuncionalidadeModel
    {
        return $this->select('MENU_FUNCIONALIDADES.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = MENU_FUNCIONALIDADES.SITUACAO_ID', 'left');
    }
}
