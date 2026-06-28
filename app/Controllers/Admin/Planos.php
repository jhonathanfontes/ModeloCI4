<?php

namespace App\Controllers\Admin;

use App\Dominios\SituacaoGeral;
use App\Modulos\Planos\Rules\PlanoRules;
use App\Modulos\Planos\Services\PlanoService;
use App\Modulos\Sistema\Models\TipoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Planos extends BaseController
{
    private PlanoService $planoService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->planoService = service('plano');
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);
        $result = $this->planoService->listar($perPage);

        return $this->render('Modulos/admin/planos/index', [
            'title' => 'Planos',
            'planos' => $result['itens'],
            'pager' => $result['pager'],
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/admin/planos/form', [
            'title' => 'Novo Plano',
            'plano' => null,
            'periodos' => $this->listarPeriodos(),
            'modulos' => $this->planoService->listarModulosComServicos(),
            'modulosVinculados' => [],
            'servicosVinculados' => [],
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function visualizar(string $uuid): ResponseInterface|string
    {
        $plano = $this->planoService->encontrarPorUuid($uuid);

        if ($plano === null) {
            return redirect()->to(route_to('admin.planos'))
                ->with('error', 'Plano não encontrado.');
        }

        return $this->render('Modulos/admin/planos/visualizar', [
            'title' => $plano->nome,
            'plano' => $plano,
            'modulosVinculados' => $this->planoService->listarModulosVinculadosComNome($plano->id),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $plano = $this->planoService->encontrarPorUuid($uuid);

        if ($plano === null) {
            return redirect()->to(route_to('admin.planos'))
                ->with('error', 'Plano não encontrado.');
        }

        return $this->render('Modulos/admin/planos/form', [
            'title' => 'Editar Plano',
            'plano' => $plano,
            'periodos' => $this->listarPeriodos(),
            'modulos' => $this->planoService->listarModulosComServicos(),
            'modulosVinculados' => $this->planoService->listarModulosVinculados($plano->id),
            'servicosVinculados' => $this->planoService->listarServicosVinculados($plano->id),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_PLANO') ?: 0);

        if (! $this->validate(PlanoRules::cadastro())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'NOME' => $this->request->getPost('NOME'),
            'DESCRICAO' => $this->request->getPost('DESCRICAO') ?: null,
            'VALOR' => $this->request->getPost('VALOR'),
            'PERIODO_ID' => $this->request->getPost('PERIODO_ID') ? (int) $this->request->getPost('PERIODO_ID') : null,
            'LIMITE_CLIENTES' => $this->request->getPost('LIMITE_CLIENTES') ? (int) $this->request->getPost('LIMITE_CLIENTES') : null,
            'LIMITE_USUARIOS' => $this->request->getPost('LIMITE_USUARIOS') ? (int) $this->request->getPost('LIMITE_USUARIOS') : null,
            'LIMITE_ARMAZENAMENTO_MB' => $this->request->getPost('LIMITE_ARMAZENAMENTO_MB') ? (int) $this->request->getPost('LIMITE_ARMAZENAMENTO_MB') : null,
            'SITUACAO' => (int) ($this->request->getPost('SITUACAO') ?: 0),
        ];

        $data['ATUALIZADO_POR'] = 1;

        $modulos = $this->request->getPost('modulos') ?? [];
        $servicos = $this->request->getPost('servicos') ?? [];

        if ($id > 0) {
            $this->planoService->atualizar($id, $data);
            $this->planoService->salvarModulos($id, $modulos);
            $this->planoService->salvarServicos($id, $servicos);

            return redirect()->to(route_to('admin.planos'))
                ->with('success', 'Plano atualizado com sucesso.');
        }

        $insertId = $this->planoService->criar($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar plano. Verifique os dados.');
        }

        $this->planoService->salvarModulos($insertId, $modulos);
        $this->planoService->salvarServicos($insertId, $servicos);

        return redirect()->to(route_to('admin.planos'))
            ->with('success', 'Plano criado com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $plano = $this->planoService->encontrarPorUuid($uuid);

        if ($plano === null) {
            return redirect()->back()
                ->with('error', 'Plano não encontrado.');
        }

        $this->planoService->excluir($plano->id);

        return redirect()->to(route_to('admin.planos'))
            ->with('success', 'Plano cancelado com sucesso.');
    }

    private function listarPeriodos(): array
    {
        return model(TipoModel::class)
            ->where('SITUACAO_ID', service('situacao')->getId(
                SituacaoGeral::modulo(),
                SituacaoGeral::ATIVO
            ))
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();
    }
}
