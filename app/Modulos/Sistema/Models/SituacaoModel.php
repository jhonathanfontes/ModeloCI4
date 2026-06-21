<?php

namespace App\Modulos\Sistema\Models;

use CodeIgniter\Model;

/**
 * @method \stdClass|null first(...$params)
 * @method \stdClass[]    findAll(...$params)
 */
class SituacaoModel extends Model
{
    protected $table            = 'SIST_SITUACOES';
    protected $primaryKey       = 'ID_SITUACAO';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
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

    protected $useTimestamps  = true;
    protected $dateFormat     = 'datetime';
    protected $createdField   = 'CRIADO_EM';
    protected $updatedField   = 'ATUALIZADO_EM';
    protected $deletedField   = 'EXCLUIDO_EM';

    protected $validationRules = [
        'UUID'    => 'required|max_length[36]',
        'MODULO'  => 'required|max_length[100]',
        'CODIGO'  => 'required|max_length[50]',
        'DESCRICAO' => 'required|max_length[255]',
    ];
}
