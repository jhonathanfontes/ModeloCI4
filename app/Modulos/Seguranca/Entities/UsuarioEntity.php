<?php

namespace App\Modulos\Seguranca\Entities;

use App\Dominios\SituacaoRegistro;
use CodeIgniter\Entity\Entity;

class UsuarioEntity extends Entity
{
    protected $casts = [
        'ID_USUARIO'       => 'integer',
        'TENTATIVAS_LOGIN' => 'integer',
        'SITUACAO_ID'      => 'integer',
        'CRIADO_POR'       => '?integer',
        'ATUALIZADO_POR'   => '?integer',
        'EXCLUIDO_POR'     => '?integer',
    ];

    protected $datamap = [
        'id'              => 'ID_USUARIO',
        'uuid'            => 'UUID',
        'nome'            => 'NOME',
        'email'           => 'EMAIL',
        'senhaHash'       => 'SENHA_HASH',
        'tipo'            => 'TIPO',
        'ultimoLogin'     => 'ULTIMO_LOGIN',
        'ultimoIp'        => 'ULTIMO_IP',
        'emailVerificadoEm' => 'EMAIL_VERIFICADO_EM',
        'tentativasLogin' => 'TENTATIVAS_LOGIN',
        'bloqueadoAte'    => 'BLOQUEADO_ATE',
        'situacaoId'      => 'SITUACAO_ID',
    ];

    protected $hidden = [
        'SENHA_HASH',
    ];

    public function isAtivo(): bool
    {
        return $this->attributes['SITUACAO_ID'] === service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );
    }

    public function isBloqueado(): bool
    {
        return $this->attributes['SITUACAO_ID'] === service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::BLOQUEADO
        );
    }
}
