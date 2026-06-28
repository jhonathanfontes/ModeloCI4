<?php

namespace App\Controllers\Admin;

use App\Dominios\SituacaoGeral;
use App\Helpers\Uuid;
use App\Modulos\Cadastro\Models\EmpresaLicencaModel;
use App\Modulos\Cadastro\Models\EmpresaModuloModel;
use App\Modulos\Cadastro\Models\EmpresaServicoModel;
use App\Modulos\Cadastro\Services\EmpresaService;
use App\Modulos\Planos\Services\PlanoService;
use CodeIgniter\HTTP\ResponseInterface;

class EmpresaServicos extends BaseController
{
    private EmpresaService $empresaService;
    private PlanoService $planoService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->empresaService = service('empresa');
        $this->planoService = service('plano');
    }

    public function index(string $empresaUuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $licenca = model(EmpresaLicencaModel::class)
            ->comPlano()
            ->where('EMPR_LICENCAS.EMPRESA_ID', $empresa->id)
            ->where('EMPR_LICENCAS.EXCLUIDO_EM', null)
            ->first();

        $planos = $this->planoService->listar(100)['itens'];
        $editMode = $this->request->getGet('edit') === '1';

        $modulos = [];
        $modulosAtivosIds = [];
        $servicosAtivosIds = [];
        $servicosDoPlanoIds = [];

        if ($licenca !== null) {
            $licenca = (object) $licenca;
            $planoId = (int) $licenca->PLANO_ID;

            $modulos = $this->planoService->listarModulosComServicos();

            $modulosAtivos = model(EmpresaModuloModel::class)
                ->comModulo()
                ->where('EMPR_EMPRESA_MODULOS.EMPRESA_ID', $empresa->id)
                ->where('EMPR_EMPRESA_MODULOS.ATIVO', 1)
                ->where('EMPR_EMPRESA_MODULOS.EXCLUIDO_EM', null)
                ->findAll();

            $modulosAtivosIds = array_map(fn (object $m) => (int) $m->MODULO_ID, $modulosAtivos);

            $servicosAtivos = model(EmpresaServicoModel::class)
                ->comServico()
                ->where('EMPR_EMPRESA_SERVICOS.EMPRESA_ID', $empresa->id)
                ->where('EMPR_EMPRESA_SERVICOS.ATIVO', 1)
                ->where('EMPR_EMPRESA_SERVICOS.EXCLUIDO_EM', null)
                ->findAll();

            $servicosAtivosIds = array_map(fn (object $s) => (int) $s->SERVICO_ID, $servicosAtivos);
            $servicosDoPlanoIds = $this->planoService->listarServicosVinculados($planoId);
        }

        return $this->render('Modulos/admin/empresas/servicos', [
            'title' => 'Serviços - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'licenca' => $licenca,
            'planos' => $planos,
            'modulos' => $modulos,
            'editMode' => $editMode,
            'modulosAtivosIds' => $modulosAtivosIds,
            'servicosAtivosIds' => $servicosAtivosIds,
            'servicosDoPlanoIds' => $servicosDoPlanoIds,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvarLicenca(string $empresaUuid): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $planoId = (int) $this->request->getPost('PLANO_ID');

        if ($planoId <= 0) {
            return redirect()->back()
                ->with('error', 'Selecione um plano.');
        }

        $licencaModel = model(EmpresaLicencaModel::class);

        $licencaModel->builder()->where('EMPRESA_ID', $empresa->id)->delete();

        $licencaModel->insert([
            'UUID' => Uuid::generate('EMPR_LICENCAS_' . microtime()),
            'EMPRESA_ID' => $empresa->id,
            'PLANO_ID' => $planoId,
            'SITUACAO_ID' => service('situacao')->getId(
                SituacaoGeral::modulo(),
                SituacaoGeral::ATIVO
            ),
        ]);

        $this->salvarModulosPorPlano($empresa->id, $planoId);

        $servicosPlano = $this->planoService->listarServicosVinculados($planoId);

        $servicoModel = model(EmpresaServicoModel::class);

        $servicoModel->builder()->where('EMPRESA_ID', $empresa->id)->delete();

        foreach ($servicosPlano as $servicoId) {
            $servicoModel->insert([
                'UUID' => Uuid::generate('EMPR_SERVICOS_' . microtime()),
                'EMPRESA_ID' => $empresa->id,
                'SERVICO_ID' => $servicoId,
                'ATIVO' => 1,
            ]);
        }

        return redirect()->to(route_to('admin.empresas.servicos', $empresa->uuid))
            ->with('success', 'Plano vinculado com sucesso.');
    }

    public function salvarServicos(string $empresaUuid): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $servicos = $this->request->getPost('servicos') ?? [];
        $servicoIds = array_map('intval', $servicos);

        $this->salvarModulosPorServicos($empresa->id, $servicoIds);

        $servicoModel = model(EmpresaServicoModel::class);

        $servicoModel->builder()->where('EMPRESA_ID', $empresa->id)->delete();

        foreach ($servicoIds as $servicoId) {
            $servicoModel->insert([
                'UUID' => Uuid::generate('EMPR_SERVICOS_' . microtime()),
                'EMPRESA_ID' => $empresa->id,
                'SERVICO_ID' => $servicoId,
                'ATIVO' => 1,
            ]);
        }

        return redirect()->to(route_to('admin.empresas.servicos', $empresa->uuid))
            ->with('success', 'Serviços atualizados com sucesso.');
    }

    private function salvarModulosPorPlano(int $empresaId, int $planoId): void
    {
        $moduloModel = model(EmpresaModuloModel::class);

        $moduloModel->builder()->where('EMPRESA_ID', $empresaId)->delete();

        $modulosPlano = $this->planoService->listarModulosVinculados($planoId);

        foreach ($modulosPlano as $moduloId) {
            $moduloModel->insert([
                'UUID' => Uuid::generate('EMPR_MODULOS_' . microtime()),
                'EMPRESA_ID' => $empresaId,
                'MODULO_ID' => $moduloId,
                'ATIVO' => 1,
            ]);
        }
    }

    private function salvarModulosPorServicos(int $empresaId, array $servicoIds): void
    {
        $moduloModel = model(EmpresaModuloModel::class);

        $moduloModel->builder()->where('EMPRESA_ID', $empresaId)->delete();

        if (empty($servicoIds)) {
            return;
        }

        $db = db_connect();
        $builder = $db->table('MENU_SERVICOS');
        $modulos = $builder
            ->select('MODULO_ID')
            ->whereIn('ID_SERVICO', $servicoIds)
            ->groupBy('MODULO_ID')
            ->get()
            ->getResult();

        foreach ($modulos as $modulo) {
            $moduloModel->insert([
                'UUID' => Uuid::generate('EMPR_MODULOS_' . microtime()),
                'EMPRESA_ID' => $empresaId,
                'MODULO_ID' => (int) $modulo->MODULO_ID,
                'ATIVO' => 1,
            ]);
        }
    }
}
