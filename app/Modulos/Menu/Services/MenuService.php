<?php

namespace App\Modulos\Menu\Services;

use App\Dominios\SituacaoRegistro;
use App\Helpers\Uuid;
use App\Modulos\Menu\DTO\FuncionalidadeDTO;
use App\Modulos\Menu\DTO\ModuloDTO;
use App\Modulos\Menu\DTO\ServicoDTO;
use App\Modulos\Menu\Models\FuncionalidadeModel;
use App\Modulos\Menu\Models\ModuloModel;
use App\Modulos\Menu\Models\ServicoModel;

class MenuService
{
    public function listarModulos(int $perPage = 20): array
    {
        $model = model(ModuloModel::class);

        $rows = $model->comSituacao()
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => ModuloDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function listarModulosComServicos(): array
    {
        $model = model(ModuloModel::class);
        $servicoModel = model(ServicoModel::class);

        $modulos = $model->comSituacao()
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(function ($modulo) use ($servicoModel) {
            $dto = ModuloDTO::fromObject($modulo);

            $servicos = $servicoModel->comSituacao()
                ->where('MODULO_ID', $dto->id)
                ->orderBy('ORDEM', 'ASC')
                ->orderBy('NOME', 'ASC')
                ->findAll();

            $dtoServicos = array_map(fn ($s) => ServicoDTO::fromObject($s), $servicos);

            return new ModuloDTO(
                id: $dto->id,
                uuid: $dto->uuid,
                nome: $dto->nome,
                descricao: $dto->descricao,
                icone: $dto->icone,
                urlRota: $dto->urlRota,
                ordem: $dto->ordem,
                situacaoId: $dto->situacaoId,
                situacaoCodigo: $dto->situacaoCodigo,
                situacaoCor: $dto->situacaoCor,
                situacaoDescricao: $dto->situacaoDescricao,
                servicos: $dtoServicos,
                criadoEm: $dto->criadoEm,
                atualizadoEm: $dto->atualizadoEm,
            );
        }, $modulos);
    }

    public function encontrarModulo(int $id): ?ModuloDTO
    {
        $model = model(ModuloModel::class);

        $row = $model->comSituacao()->find($id);

        return $row !== null ? ModuloDTO::fromObject($row) : null;
    }

    public function encontrarModuloPorUuid(string $uuid): ?ModuloDTO
    {
        $model = model(ModuloModel::class);

        $row = $model->comSituacao()->findByUuid($uuid);

        return $row !== null ? ModuloDTO::fromObject($row) : null;
    }

    public function criarModulo(array $data): ?int
    {
        $model = model(ModuloModel::class);

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $data['UUID'] = Uuid::generate('MENU_MODULOS_' . microtime());

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizarModulo(int $id, array $data): bool
    {
        $model = model(ModuloModel::class);

        unset($data['ID_MODULO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data) !== false;
    }

    public function excluirModulo(int $id): bool
    {
        $model = model(ModuloModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function listarServicos(?int $moduloId = null, int $perPage = 20): array
    {
        $model = model(ServicoModel::class);

        $query = $model->comModulo()->comSituacao();

        if ($moduloId !== null) {
            $query->where('MENU_SERVICOS.MODULO_ID', $moduloId);
        }

        $rows = $query->orderBy('MENU_SERVICOS.ORDEM', 'ASC')
            ->orderBy('MENU_SERVICOS.NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => ServicoDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrarServico(int $id): ?ServicoDTO
    {
        $model = model(ServicoModel::class);

        $row = $model->comModulo()->comSituacao()->find($id);

        return $row !== null ? ServicoDTO::fromObject($row) : null;
    }

    public function encontrarServicoPorUuid(string $uuid): ?ServicoDTO
    {
        $model = model(ServicoModel::class);

        $row = $model->comModulo()->comSituacao()->findByUuid($uuid);

        return $row !== null ? ServicoDTO::fromObject($row) : null;
    }

    public function criarServico(array $data): ?int
    {
        $model = model(ServicoModel::class);

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $data['UUID'] = Uuid::generate('MENU_SERVICOS_' . microtime());

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizarServico(int $id, array $data): bool
    {
        $model = model(ServicoModel::class);

        unset($data['ID_SERVICO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data) !== false;
    }

    public function copiarServico(int $id): ?int
    {
        $original = $this->encontrarServico($id);

        if ($original === null) {
            return null;
        }

        $data = [
            'MODULO_ID' => $original->moduloId,
            'NOME' => $original->nome . ' (cópia)',
            'DESCRICAO' => $original->descricao,
            'URL_MODULO' => $original->urlModulo,
            'URL_ROTA' => $original->urlRota,
            'ICONE' => $original->icone,
            'ORDEM' => $original->ordem,
            'DASHBOARD' => $original->dashboard ? 1 : 0,
            'SITUACAO_ID' => $original->situacaoId,
        ];

        return $this->criarServico($data);
    }

    public function excluirServico(int $id): bool
    {
        $model = model(ServicoModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function listarFuncionalidades(?int $servicoId = null, int $perPage = 20): array
    {
        $model = model(FuncionalidadeModel::class);

        $query = $model->comServico()->comSituacao();

        if ($servicoId !== null) {
            $query->where('MENU_FUNCIONALIDADES.SERVICO_ID', $servicoId);
        }

        $rows = $query->orderBy('MENU_FUNCIONALIDADES.NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => FuncionalidadeDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function listarFuncionalidadesPorServico(int $servicoId): array
    {
        $model = model(FuncionalidadeModel::class);

        $rows = $model->comSituacao()
            ->where('SERVICO_ID', $servicoId)
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(fn ($row) => FuncionalidadeDTO::fromObject($row), $rows);
    }

    public function encontrarFuncionalidade(int $id): ?FuncionalidadeDTO
    {
        $model = model(FuncionalidadeModel::class);

        $row = $model->comServico()->comSituacao()->find($id);

        return $row !== null ? FuncionalidadeDTO::fromObject($row) : null;
    }

    public function encontrarFuncionalidadePorUuid(string $uuid): ?FuncionalidadeDTO
    {
        $model = model(FuncionalidadeModel::class);

        $row = $model->comServico()->comSituacao()->findByUuid($uuid);

        return $row !== null ? FuncionalidadeDTO::fromObject($row) : null;
    }

    public function criarFuncionalidade(array $data): ?int
    {
        $model = model(FuncionalidadeModel::class);

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $data['UUID'] = Uuid::generate('MENU_FUNCIONALIDADES_' . microtime());

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizarFuncionalidade(int $id, array $data): bool
    {
        $model = model(FuncionalidadeModel::class);

        unset($data['ID_FUNCIONALIDADE'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data) !== false;
    }

    public function excluirFuncionalidade(int $id): bool
    {
        $model = model(FuncionalidadeModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function listarTodosModulos(): array
    {
        $model = model(ModuloModel::class);

        $rows = $model->comSituacao()
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(fn ($row) => ModuloDTO::fromObject($row), $rows);
    }

    public function listarServicosPorModulo(int $moduloId): array
    {
        $model = model(ServicoModel::class);

        $rows = $model->comSituacao()
            ->where('MODULO_ID', $moduloId)
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return array_map(fn ($row) => ServicoDTO::fromObject($row), $rows);
    }

    public function montarMenuPainel(int $empresaId): array
    {
        $db = db_connect();

        $modulos = $db->table('EMPR_EMPRESA_MODULOS')
            ->select('MENU_MODULOS.ID_MODULO, MENU_MODULOS.NOME, MENU_MODULOS.ICONE, MENU_MODULOS.URL_ROTA')
            ->join('MENU_MODULOS', 'MENU_MODULOS.ID_MODULO = EMPR_EMPRESA_MODULOS.MODULO_ID')
            ->where('EMPR_EMPRESA_MODULOS.EMPRESA_ID', $empresaId)
            ->where('EMPR_EMPRESA_MODULOS.ATIVO', 1)
            ->where('EMPR_EMPRESA_MODULOS.EXCLUIDO_EM', null)
            ->where('MENU_MODULOS.EXCLUIDO_EM', null)
            ->orderBy('MENU_MODULOS.ORDEM', 'ASC')
            ->orderBy('MENU_MODULOS.NOME', 'ASC')
            ->get()
            ->getResult();

        if (empty($modulos)) {
            return [];
        }

        $moduloIds = array_map(fn ($m) => (int) $m->ID_MODULO, $modulos);

        $servicos = $db->table('EMPR_EMPRESA_SERVICOS')
            ->select('MENU_SERVICOS.ID_SERVICO, MENU_SERVICOS.MODULO_ID, MENU_SERVICOS.NOME, MENU_SERVICOS.ICONE, MENU_SERVICOS.URL_ROTA, MENU_SERVICOS.URL_MODULO')
            ->join('MENU_SERVICOS', 'MENU_SERVICOS.ID_SERVICO = EMPR_EMPRESA_SERVICOS.SERVICO_ID')
            ->where('EMPR_EMPRESA_SERVICOS.EMPRESA_ID', $empresaId)
            ->where('EMPR_EMPRESA_SERVICOS.ATIVO', 1)
            ->where('EMPR_EMPRESA_SERVICOS.EXCLUIDO_EM', null)
            ->where('MENU_SERVICOS.EXCLUIDO_EM', null)
            ->whereIn('MENU_SERVICOS.MODULO_ID', $moduloIds)
            ->orderBy('MENU_SERVICOS.ORDEM', 'ASC')
            ->orderBy('MENU_SERVICOS.NOME', 'ASC')
            ->get()
            ->getResult();

        $servicosPorModulo = [];

        foreach ($servicos as $s) {
            $moduloId = (int) $s->MODULO_ID;

            $servicosPorModulo[$moduloId][] = [
                'id' => (int) $s->ID_SERVICO,
                'nome' => $s->NOME,
                'icone' => $s->ICONE,
                'urlRota' => $s->URL_ROTA,
                'urlModulo' => $s->URL_MODULO,
            ];
        }

        $menu = [];

        foreach ($modulos as $m) {
            $moduloId = (int) $m->ID_MODULO;

            $menu[] = [
                'id' => $moduloId,
                'nome' => $m->NOME,
                'icone' => $m->ICONE,
                'urlRota' => $m->URL_ROTA,
                'servicos' => $servicosPorModulo[$moduloId] ?? [],
            ];
        }

        return $menu;
    }
}
