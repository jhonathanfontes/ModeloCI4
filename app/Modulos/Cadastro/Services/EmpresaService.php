<?php

namespace App\Modulos\Cadastro\Services;

use App\Dominios\SituacaoRegistro;
use App\Helpers\Uuid;
use App\Modulos\Cadastro\DTO\EmpresaDTO;
use App\Modulos\Cadastro\Models\EmpresaModel;

class EmpresaService
{
    public function listar(int $perPage = 20): array
    {
        $model = model(EmpresaModel::class);

        $rows = $model->comSituacao()
            ->orderBy('NOME_FANTASIA', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => EmpresaDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrar(int $id): ?EmpresaDTO
    {
        $model = model(EmpresaModel::class);

        $row = $model->comSituacao()->find($id);

        return $row !== null ? EmpresaDTO::fromObject($row) : null;
    }

    public function encontrarPorUuid(string $uuid): ?EmpresaDTO
    {
        $model = model(EmpresaModel::class);

        $row = $model->comSituacao()->where('EMPRESAS.UUID', $uuid)->first();

        return $row !== null ? EmpresaDTO::fromObject($row) : null;
    }

    public function criar(array $data): ?int
    {
        $model = model(EmpresaModel::class);

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $data['UUID'] = Uuid::generate('EMPRESAS_' . microtime());

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizar(int $id, array $data): bool
    {
        $model = model(EmpresaModel::class);

        unset($data['ID_EMPRESA'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data) !== false;
    }

    public function excluir(int $id): bool
    {
        $model = model(EmpresaModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function deletarFisicamente(int $id): bool
    {
        return model(EmpresaModel::class)->delete($id);
    }

    public function listarTodas(): array
    {
        $model = model(EmpresaModel::class);

        $rows = $model->comSituacao()
            ->orderBy('NOME_FANTASIA', 'ASC')
            ->findAll();

        return array_map(fn ($row) => EmpresaDTO::fromObject($row), $rows);
    }
}
