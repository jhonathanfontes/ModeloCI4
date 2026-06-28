<?php

namespace App\Modulos\Sistema\Models;

use App\Helpers\Uuid;
use CodeIgniter\Model;

/**
 * @method \stdClass|null first(...$params)
 * @method \stdClass[]    findAll(...$params)
 */
class SituacaoModel extends Model
{
    protected $table = 'SIST_SITUACOES';
    protected $primaryKey = 'ID_SITUACAO';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'ID_SITUACAO',
        'UUID',
        'MODULO',
        'CODIGO',
        'DESCRICAO',
        'COR',
        'ICONE',
        'FINALIZADO',
        'CONCLUIDA',
        'CANCELADA',
        'PENDENTE',
        'BLOQUEIA_EDICAO',
        'GERA_HISTORICO',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'CRIADO_EM';
    protected $updatedField = 'ATUALIZADO_EM';
    protected $deletedField = 'EXCLUIDO_EM';

    protected $beforeInsert = ['gerarUuid'];

    protected $validationRules = [
        'UUID' => 'required|max_length[36]',
        'MODULO' => 'required|max_length[100]',
        'CODIGO' => 'required|max_length[50]',
        'DESCRICAO' => 'required|max_length[255]',
    ];

    protected function gerarUuid(array $data): array
    {
        if (! isset($data['data']['UUID'])) {
            $data['data']['UUID'] = Uuid::generate('SIST_SITUACOES_' . microtime());
        }
        return $data;
    }
}
