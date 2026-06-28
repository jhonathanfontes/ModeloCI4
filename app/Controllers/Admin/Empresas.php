<?php

namespace App\Controllers\Admin;

use App\Modulos\Cadastro\Rules\EmpresaRules;
use App\Modulos\Cadastro\Services\EmpresaService;
use CodeIgniter\HTTP\ResponseInterface;

class Empresas extends BaseController
{
    private EmpresaService $empresaService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->empresaService = service('empresa');
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $result = $this->empresaService->listar($perPage);

        return $this->render('Modulos/admin/empresas/index', [
            'title' => 'Empresas',
            'empresas' => $result['itens'],
            'pager' => $result['pager'],
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/admin/empresas/form', [
            'title' => 'Nova Empresa',
            'empresa' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function visualizar(string $uuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($uuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $usuarios = service('usuarioRepository')->usuariosDaEmpresa($empresa->id);

        return $this->render('Modulos/admin/empresas/visualizar', [
            'title' => $empresa->nomeFantasia,
            'empresa' => $empresa,
            'usuarios' => $usuarios,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($uuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        return $this->render('Modulos/admin/empresas/form', [
            'title' => 'Editar Empresa',
            'empresa' => $empresa,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_EMPRESA') ?: 0);

        $data = [
            'RAZAO_SOCIAL' => $this->request->getPost('RAZAO_SOCIAL'),
            'NOME_FANTASIA' => $this->request->getPost('NOME_FANTASIA'),
            'CPF_CNPJ' => preg_replace('/\D/', '', $this->request->getPost('CPF_CNPJ') ?? ''),
            'EMAIL' => $this->request->getPost('EMAIL'),
            'TELEFONE' => preg_replace('/\D/', '', $this->request->getPost('TELEFONE') ?? ''),
            'CELULAR' => preg_replace('/\D/', '', $this->request->getPost('CELULAR') ?? ''),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $rules = $id > 0 ? EmpresaRules::atualizacao($id) : EmpresaRules::cadastro();

        if (! $this->validateData($data, $rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            if (! $this->empresaService->atualizar($id, $data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Erro ao atualizar empresa. Verifique os dados.');
            }

            return redirect()->to(route_to('admin.empresas'))
                ->with('success', 'Empresa atualizada com sucesso.');
        }

        $insertId = $this->empresaService->criar($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar empresa. Verifique os dados.');
        }

        return redirect()->to(route_to('admin.empresas'))
            ->with('success', 'Empresa criada com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($uuid);

        if ($empresa === null) {
            return redirect()->back()
                ->with('error', 'Empresa não encontrada.');
        }

        $this->empresaService->excluir($empresa->id);

        return redirect()->to(route_to('admin.empresas'))
            ->with('success', 'Empresa cancelada com sucesso.');
    }
}
