<?php

namespace App\Modulos\Menu\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class ServicoModel extends Model
{
    protected $table            = 'MENU_SERVICOS';
    protected $primaryKey       = 'ID_SERVICO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'UUID',
        'MODULO_ID',
        'NOME',
        'DESCRICAO',
        'URL_MODULO',
        'URL_ROTA',
        'ICONE',
        'ORDEM',
        'DASHBOARD',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CRIADO_EM';
    protected $updatedField  = 'ATUALIZADO_EM';
    protected $deletedField  = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'        => 'required|max_length[36]',
        'MODULO_ID'   => 'required|integer',
        'NOME'        => 'required|max_length[100]',
        'URL_MODULO'  => 'permit_empty|max_length[255]',
        'URL_ROTA'    => 'permit_empty|max_length[255]',
        'ICONE'       => 'permit_empty|max_length[50]',
        'ORDEM'       => 'permit_empty|integer',
        'DASHBOARD'   => 'permit_empty|integer',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (!isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('MENU_SERVICOS_' . microtime());
        }
        return $data;
    }

    public function comModulo(): ServicoModel
    {
        return $this->select('MENU_SERVICOS.*, MENU_MODULOS.NOME AS MODULO_NOME')
            ->join('MENU_MODULOS', 'MENU_MODULOS.ID_MODULO = MENU_SERVICOS.MODULO_ID', 'left');
    }

    public function comSituacao(): ServicoModel
    {
        return $this->select('MENU_SERVICOS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = MENU_SERVICOS.SITUACAO_ID', 'left');
    }
}
