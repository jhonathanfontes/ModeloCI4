<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\ResponseInterface;
use App\Modulos\Menu\Rules\FuncionalidadeRules;
use App\Modulos\Menu\Rules\ModuloRules;
use App\Modulos\Menu\Rules\ServicoRules;
use App\Modulos\Menu\Services\MenuService;
use App\Modulos\Sistema\Models\SituacaoModel;

class Menu extends BaseController
{
    private MenuService $menuService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->menuService = service('menu');
    }

    public function index(): string
    {
        $modulos = $this->menuService->listarModulosComServicos();

        return $this->render('Modulos/admin/menu/index', [
            'title'   => 'Gerenciar Menu',
            'modulos' => $modulos,
        ]);
    }

    // ─── Módulos ───────────────────────────────────────────────────

    public function moduloNovo(): string
    {
        return $this->render('Modulos/admin/menu/modulo_form', [
            'title'     => 'Novo Módulo',
            'modulo'    => null,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function moduloEditar(int $id): ResponseInterface|string
    {
        $modulo = $this->menuService->encontrarModulo($id);

        if ($modulo === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Módulo não encontrado.');
        }

        return $this->render('Modulos/admin/menu/modulo_form', [
            'title'     => 'Editar Módulo',
            'modulo'    => $modulo,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function moduloSalvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_MODULO') ?: 0);

        if (! $this->validate(ModuloRules::cadastro())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'NOME'        => $this->request->getPost('NOME'),
            'DESCRICAO'   => $this->request->getPost('DESCRICAO') ?: null,
            'ICONE'       => $this->request->getPost('ICONE') ?: null,
            'URL_ROTA'    => $this->request->getPost('URL_ROTA') ?: null,
            'ORDEM'       => $this->request->getPost('ORDEM') ? (int) $this->request->getPost('ORDEM') : null,
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            $this->menuService->atualizarModulo($id, $data);

            return redirect()->to(route_to('admin.menu'))
                ->with('success', 'Módulo atualizado com sucesso.');
        }

        $insertId = $this->menuService->criarModulo($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar módulo. Verifique os dados.');
        }

        return redirect()->to(route_to('admin.menu'))
            ->with('success', 'Módulo criado com sucesso.');
    }

    public function moduloExcluir(int $id): ResponseInterface
    {
        $modulo = $this->menuService->encontrarModulo($id);

        if ($modulo === null) {
            return redirect()->back()
                ->with('error', 'Módulo não encontrado.');
        }

        $this->menuService->excluirModulo($id);

        return redirect()->to(route_to('admin.menu'))
            ->with('success', 'Módulo cancelado com sucesso.');
    }

    // ─── Serviços ──────────────────────────────────────────────────

    public function servicos(int $moduloId): ResponseInterface|string
    {
        $modulo = $this->menuService->encontrarModulo($moduloId);

        if ($modulo === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Módulo não encontrado.');
        }

        $perPage = (int) ($this->request->getGet('per_page') ?: 20);
        $result = $this->menuService->listarServicos($moduloId, $perPage);

        return $this->render('Modulos/admin/menu/servicos', [
            'title'    => 'Serviços: ' . $modulo->nome,
            'modulo'   => $modulo,
            'servicos' => $result['itens'],
            'pager'    => $result['pager'],
            'success'  => session()->getFlashdata('success'),
            'error'    => session()->getFlashdata('error'),
        ]);
    }

    public function servicoNovo(int $moduloId): ResponseInterface|string
    {
        $modulo = $this->menuService->encontrarModulo($moduloId);

        if ($modulo === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Módulo não encontrado.');
        }

        return $this->render('Modulos/admin/menu/servico_form', [
            'title'     => 'Novo Serviço em ' . $modulo->nome,
            'modulo'    => $modulo,
            'servico'   => null,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function servicoEditar(int $id): ResponseInterface|string
    {
        $servico = $this->menuService->encontrarServico($id);

        if ($servico === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Serviço não encontrado.');
        }

        $modulo = $this->menuService->encontrarModulo($servico->moduloId);

        return $this->render('Modulos/admin/menu/servico_form', [
            'title'     => 'Editar Serviço',
            'modulo'    => $modulo,
            'servico'   => $servico,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function servicoSalvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_SERVICO') ?: 0);
        $moduloId = (int) $this->request->getPost('MODULO_ID');

        if (! $this->validate(ServicoRules::cadastro())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'MODULO_ID'   => $moduloId,
            'NOME'        => $this->request->getPost('NOME'),
            'DESCRICAO'   => $this->request->getPost('DESCRICAO') ?: null,
            'URL_MODULO'  => $this->request->getPost('URL_MODULO') ?: null,
            'URL_ROTA'    => $this->request->getPost('URL_ROTA') ?: null,
            'ICONE'       => $this->request->getPost('ICONE') ?: null,
            'ORDEM'       => $this->request->getPost('ORDEM') ? (int) $this->request->getPost('ORDEM') : null,
            'DASHBOARD'   => $this->request->getPost('DASHBOARD') ? 1 : 0,
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            $this->menuService->atualizarServico($id, $data);

            return redirect()->to(route_to('admin.menu.servicos', $moduloId))
                ->with('success', 'Serviço atualizado com sucesso.');
        }

        $insertId = $this->menuService->criarServico($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar serviço. Verifique os dados.');
        }

        return redirect()->to(route_to('admin.menu.servicos', $moduloId))
            ->with('success', 'Serviço criado com sucesso.');
    }

    public function servicoCopiar(int $id): ResponseInterface
    {
        $servico = $this->menuService->encontrarServico($id);

        if ($servico === null) {
            return redirect()->back()
                ->with('error', 'Serviço não encontrado.');
        }

        $insertId = $this->menuService->copiarServico($id);

        if ($insertId === null) {
            return redirect()->to(route_to('admin.menu.servicos', $servico->moduloId))
                ->with('error', 'Erro ao copiar serviço.');
        }

        return redirect()->to(route_to('admin.menu.servicos', $servico->moduloId))
            ->with('success', 'Serviço copiado com sucesso.');
    }

    public function servicoExcluir(int $id): ResponseInterface
    {
        $servico = $this->menuService->encontrarServico($id);

        if ($servico === null) {
            return redirect()->back()
                ->with('error', 'Serviço não encontrado.');
        }

        $this->menuService->excluirServico($id);

        return redirect()->to(route_to('admin.menu.servicos', $servico->moduloId))
            ->with('success', 'Serviço cancelado com sucesso.');
    }

    // ─── Funcionalidades ───────────────────────────────────────────

    public function funcionalidades(int $servicoId): ResponseInterface|string
    {
        $servico = $this->menuService->encontrarServico($servicoId);

        if ($servico === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Serviço não encontrado.');
        }

        $perPage = (int) ($this->request->getGet('per_page') ?: 20);
        $result = $this->menuService->listarFuncionalidades($servicoId, $perPage);

        return $this->render('Modulos/admin/menu/funcionalidades', [
            'title'           => 'Funcionalidades: ' . $servico->nome,
            'servico'         => $servico,
            'funcionalidades' => $result['itens'],
            'pager'           => $result['pager'],
            'success'         => session()->getFlashdata('success'),
            'error'           => session()->getFlashdata('error'),
        ]);
    }

    public function funcionalidadeNovo(int $servicoId): ResponseInterface|string
    {
        $servico = $this->menuService->encontrarServico($servicoId);

        if ($servico === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Serviço não encontrado.');
        }

        return $this->render('Modulos/admin/menu/funcionalidade_form', [
            'title'           => 'Nova Funcionalidade em ' . $servico->nome,
            'servico'         => $servico,
            'funcionalidade'  => null,
            'situacoes'       => $this->listarSituacoes(),
            'success'         => session()->getFlashdata('success'),
            'error'           => session()->getFlashdata('error'),
            'errors'          => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function funcionalidadeEditar(int $id): ResponseInterface|string
    {
        $funcionalidade = $this->menuService->encontrarFuncionalidade($id);

        if ($funcionalidade === null) {
            return redirect()->to(route_to('admin.menu'))
                ->with('error', 'Funcionalidade não encontrada.');
        }

        $servico = $this->menuService->encontrarServico($funcionalidade->servicoId);

        return $this->render('Modulos/admin/menu/funcionalidade_form', [
            'title'          => 'Editar Funcionalidade',
            'servico'        => $servico,
            'funcionalidade' => $funcionalidade,
            'situacoes'      => $this->listarSituacoes(),
            'success'        => session()->getFlashdata('success'),
            'error'          => session()->getFlashdata('error'),
            'errors'         => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function funcionalidadeSalvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_FUNCIONALIDADE') ?: 0);
        $servicoId = (int) $this->request->getPost('SERVICO_ID');

        if (! $this->validate(FuncionalidadeRules::cadastro())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'SERVICO_ID'  => $servicoId,
            'NOME'        => $this->request->getPost('NOME'),
            'DESCRICAO'   => $this->request->getPost('DESCRICAO') ?: null,
            'CHAVE'       => $this->request->getPost('CHAVE'),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            $this->menuService->atualizarFuncionalidade($id, $data);

            return redirect()->to(route_to('admin.menu.funcionalidades', $servicoId))
                ->with('success', 'Funcionalidade atualizada com sucesso.');
        }

        $insertId = $this->menuService->criarFuncionalidade($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar funcionalidade. Verifique os dados.');
        }

        return redirect()->to(route_to('admin.menu.funcionalidades', $servicoId))
            ->with('success', 'Funcionalidade criada com sucesso.');
    }

    public function funcionalidadeExcluir(int $id): ResponseInterface
    {
        $funcionalidade = $this->menuService->encontrarFuncionalidade($id);

        if ($funcionalidade === null) {
            return redirect()->back()
                ->with('error', 'Funcionalidade não encontrada.');
        }

        $this->menuService->excluirFuncionalidade($id);

        return redirect()->to(route_to('admin.menu.funcionalidades', $funcionalidade->servicoId))
            ->with('success', 'Funcionalidade cancelada com sucesso.');
    }

    // ─── Helpers ───────────────────────────────────────────────────

    private function listarSituacoes(): array
    {
        return model(SituacaoModel::class)
            ->where('MODULO', \App\Dominios\SituacaoRegistro::MODULO)
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();
    }
}
