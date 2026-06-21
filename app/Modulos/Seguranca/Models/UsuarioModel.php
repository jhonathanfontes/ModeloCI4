<?php

namespace App\Modulos\Seguranca\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'SEGU_USUARIOS';
    protected $primaryKey       = 'ID_USUARIO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'UUID',
        'NOME',
        'EMAIL',
        'SENHA_HASH',
        'TIPO',
        'ULTIMO_LOGIN',
        'ULTIMO_IP',
        'EMAIL_VERIFICADO_EM',
        'TENTATIVAS_LOGIN',
        'BLOQUEADO_ATE',
        'SITUACAO_ID',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'CRIADO_EM';
    protected $updatedField  = 'ATUALIZADO_EM';
    protected $deletedField  = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'       => 'required|max_length[36]',
        'NOME'       => 'required|max_length[255]',
        'EMAIL'      => 'required|valid_email|max_length[255]|is_unique[SEGU_USUARIOS.EMAIL]',
        'SENHA_HASH' => 'required|max_length[255]',
        'TIPO'       => 'required|in_list[SYSTEM,EMPRESA,CLIENTE]',
        'SITUACAO_ID'=> 'required|integer',
    ];

    protected $beforeInsert = ['gerarUuid'];

    protected function gerarUuid(array $data): array
    {
        if (!isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('SEGU_USUARIOS_' . microtime());
        }
        return $data;
    }

    public function findByEmail(string $email): ?object
    {
        return $this->where('EMAIL', $email)->first();
    }

    public function comSituacao(): UsuarioModel
    {
        return $this->select('SEGU_USUARIOS.*, SIST_SITUACOES.CODIGO AS SITUACAO_CODIGO, SIST_SITUACOES.COR AS SITUACAO_COR, SIST_SITUACOES.DESCRICAO AS SITUACAO_DESCRICAO')
            ->join('SIST_SITUACOES', 'SIST_SITUACOES.ID_SITUACAO = SEGU_USUARIOS.SITUACAO_ID', 'left');
    }
}
