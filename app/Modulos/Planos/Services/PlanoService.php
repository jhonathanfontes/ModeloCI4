<?php

namespace App\Modulos\Planos\Services;

use App\Helpers\Uuid;
use App\Modulos\Menu\Models\ModuloModel;
use App\Modulos\Menu\Models\ServicoModel;
use App\Modulos\Planos\DTO\PlanoDTO;
use App\Modulos\Planos\Models\PlanoModel;
use App\Modulos\Planos\Models\PlanoModuloModel;
use App\Modulos\Planos\Models\PlanoServicoModel;

class PlanoService
{
    public function listar(int $perPage = 20): array
    {
        $model = model(PlanoModel::class);

        $rows = $model
            ->orderBy('NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => PlanoDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrar(int $id): ?PlanoDTO
    {
        $model = model(PlanoModel::class);

        $row = $model->find($id);

        return $row !== null ? PlanoDTO::fromObject($row) : null;
    }

    public function encontrarPorUuid(string $uuid): ?PlanoDTO
    {
        $model = model(PlanoModel::class);

        $row = $model->where('SIST_PLANOS.UUID', $uuid)->first();

        return $row !== null ? PlanoDTO::fromObject($row) : null;
    }

    public function criar(array $data): ?int
    {
        $model = model(PlanoModel::class);

        $data['SITUACAO'] ??= 1;

        $data['UUID'] = Uuid::generate('SIST_PLANOS_' . microtime());

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizar(int $id, array $data): bool
    {
        $model = model(PlanoModel::class);

        unset($data['ID_PLANO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data) !== false;
    }

    public function excluir(int $id): bool
    {
        $model = model(PlanoModel::class);

        return $model->update($id, ['SITUACAO' => 0]);
    }

    public function listarModulosVinculados(int $planoId): array
    {
        $model = model(PlanoModuloModel::class);

        $rows = $model
            ->where('PLANO_ID', $planoId)
            ->where('SITUACAO', 1)
            ->findAll();

        return array_map(fn (object $row) => (int) $row->MODULO_ID, $rows);
    }

    public function listarServicosVinculados(int $planoId): array
    {
        $model = model(PlanoServicoModel::class);

        $rows = $model
            ->where('PLANO_ID', $planoId)
            ->where('SITUACAO', 1)
            ->findAll();

        return array_map(fn (object $row) => (int) $row->SERVICO_ID, $rows);
    }

    public function salvarModulos(int $planoId, array $moduloIds): void
    {
        $model = model(PlanoModuloModel::class);

        $model->builder()->where('PLANO_ID', $planoId)->update(['SITUACAO' => 0]);

        foreach ($moduloIds as $moduloId) {
            $exists = $model
                ->where('PLANO_ID', $planoId)
                ->where('MODULO_ID', $moduloId)
                ->first();

            if ($exists !== null) {
                $model->builder()
                    ->where('PLANO_ID', $planoId)
                    ->where('MODULO_ID', $moduloId)
                    ->update(['SITUACAO' => 1]);
            } else {
                $model->insert([
                    'PLANO_ID' => $planoId,
                    'MODULO_ID' => $moduloId,
                    'SITUACAO' => 1,
                    'UUID' => Uuid::generate('PLANO_MODULOS_' . microtime()),
                ]);
            }
        }
    }

    public function salvarServicos(int $planoId, array $servicoIds): void
    {
        $model = model(PlanoServicoModel::class);

        $model->builder()->where('PLANO_ID', $planoId)->update(['SITUACAO' => 0]);

        foreach ($servicoIds as $servicoId) {
            $exists = $model
                ->where('PLANO_ID', $planoId)
                ->where('SERVICO_ID', $servicoId)
                ->first();

            if ($exists !== null) {
                $model->builder()
                    ->where('PLANO_ID', $planoId)
                    ->where('SERVICO_ID', $servicoId)
                    ->update(['SITUACAO' => 1]);
            } else {
                $model->insert([
                    'PLANO_ID' => $planoId,
                    'SERVICO_ID' => $servicoId,
                    'SITUACAO' => 1,
                    'UUID' => Uuid::generate('PLANO_SERVICOS_' . microtime()),
                ]);
            }
        }
    }

    public function listarModulosVinculadosComNome(int $planoId): array
    {
        $vinculados = $this->listarModulosVinculados($planoId);
        $servicosVinculados = $this->listarServicosVinculados($planoId);

        if (empty($vinculados)) {
            return [];
        }

        $moduloModel = model(ModuloModel::class);
        $servicoModel = model(ServicoModel::class);

        $modulos = $moduloModel->comSituacao()
            ->whereIn('ID_MODULO', $vinculados)
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(function (object $modulo) use ($servicoModel, $servicosVinculados) {
            $servicos = $servicoModel->comSituacao()
                ->where('MODULO_ID', $modulo->ID_MODULO)
                ->whereIn('ID_SERVICO', $servicosVinculados)
                ->orderBy('ORDEM', 'ASC')
                ->orderBy('NOME', 'ASC')
                ->findAll();

            $modulo->servicos = $servicos;

            return $modulo;
        }, $modulos);
    }

    public function listarModulosComServicos(): array
    {
        $moduloModel = model(ModuloModel::class);
        $servicoModel = model(ServicoModel::class);

        $modulos = $moduloModel->comSituacao()
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(function (object $modulo) use ($servicoModel) {
            $servicos = $servicoModel->comSituacao()
                ->where('MODULO_ID', $modulo->ID_MODULO)
                ->orderBy('ORDEM', 'ASC')
                ->orderBy('NOME', 'ASC')
                ->findAll();

            $modulo->servicos = $servicos;

            return $modulo;
        }, $modulos);
    }
}
