<?php

namespace App\Modulos\Menu\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class ModuloModel extends Model
{
    protected $table            = 'MENU_MODULOS';
    protected $primaryKey       = 'ID_MODULO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'UUID',
        'NOME',
        'DESCRICAO',
        'ICONE',
        'URL_ROTA',
        'ORDEM',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CRIADO_EM';
    protected $updatedField  = 'ATUALIZADO_EM';
    protected $deletedField  = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'        => 'required|max_length[36]',
        'NOME'        => 'required|max_length[100]',
        'ICONE'       => 'permit_empty|max_length[50]',
        'URL_ROTA'    => 'permit_empty|max_length[255]',
        'ORDEM'       => 'permit_empty|integer',
        'SITUACAO_ID' => 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (!isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('MENU_MODULOS_' . microtime());
        }
        return $data;
    }

    public function comSituacao(): ModuloModel
    {
        return $this->select('MENU_MODULOS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = MENU_MODULOS.SITUACAO_ID', 'left');
    }

    public function comServicos(): ModuloModel
    {
        return $this->select('MENU_MODULOS.*')
            ->join('MENU_SERVICOS', 'MENU_SERVICOS.MODULO_ID = MENU_MODULOS.ID_MODULO AND MENU_SERVICOS.EXCLUIDO_EM IS NULL', 'left');
    }
}
