<?php

namespace App\Modulos\Seguranca\Services;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Seguranca\DTO\UsuarioDTO;
use App\Modulos\Seguranca\Models\UsuarioModel;

class UsuarioService
{
    public function listar(int $perPage = 20): array
    {
        $model = model(UsuarioModel::class);

        $rows = $model->comSituacao()
            ->orderBy('NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn($row) => UsuarioDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrar(int $id): ?UsuarioDTO
    {
        $model = model(UsuarioModel::class);

        $row = $model->comSituacao()->find($id);

        return $row !== null ? UsuarioDTO::fromObject($row) : null;
    }

    public function criar(array $data): ?int
    {
        $model = model(UsuarioModel::class);

        if (isset($data['SENHA'])) {
            $data['SENHA_HASH'] = password_hash($data['SENHA'], PASSWORD_BCRYPT);
            unset($data['SENHA']);
        }

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizar(int $id, array $data): bool
    {
        $model = model(UsuarioModel::class);

        if (isset($data['SENHA'])) {
            $data['SENHA_HASH'] = password_hash($data['SENHA'], PASSWORD_BCRYPT);
            unset($data['SENHA']);
        }

        unset($data['ID_USUARIO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data);
    }

    public function excluir(int $id): bool
    {
        $model = model(UsuarioModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function deletarFisicamente(int $id): bool
    {
        return model(UsuarioModel::class)->delete($id);
    }
}
