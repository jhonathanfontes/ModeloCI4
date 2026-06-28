<?php

namespace App\Controllers\Admin;

use App\Modulos\Cadastro\Models\EmpresaContatoModel;
use App\Modulos\Cadastro\Services\EmpresaService;
use CodeIgniter\HTTP\ResponseInterface;

class EmpresaContatos extends BaseController
{
    private EmpresaService $empresaService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->empresaService = service('empresa');
    }

    public function index(string $empresaUuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $contatos = model(EmpresaContatoModel::class)
            ->daEmpresa($empresa->id)
            ->orderBy('PRINCIPAL', 'DESC')
            ->orderBy('NOME', 'ASC')
            ->findAll();

        return $this->render('Modulos/admin/empresas/contatos', [
            'title' => 'Contatos - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'contatos' => $contatos,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function novo(string $empresaUuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        return $this->render('Modulos/admin/empresas/contatos_form', [
            'title' => 'Novo Contato - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'item' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $empresaUuid, int $contatoId): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $item = model(EmpresaContatoModel::class)->find($contatoId);

        if ($item === null || (int) $item->EMPRESA_ID !== $empresa->id) {
            return redirect()->to(route_to('admin.empresas.contatos', $empresaUuid))
                ->with('error', 'Contato não encontrado.');
        }

        return $this->render('Modulos/admin/empresas/contatos_form', [
            'title' => 'Editar Contato - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'item' => $item,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(string $empresaUuid): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $id = (int) ($this->request->getPost('ID_CONTATO') ?: 0);
        $model = model(EmpresaContatoModel::class);

        $data = [
            'EMPRESA_ID' => $empresa->id,
            'NOME' => $this->request->getPost('NOME'),
            'CARGO' => $this->request->getPost('CARGO'),
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'TELEFONE' => preg_replace('/\D/', '', $this->request->getPost('TELEFONE') ?? ''),
            'EMAIL' => $this->request->getPost('EMAIL'),
            'WHATSAPP' => preg_replace('/\D/', '', $this->request->getPost('WHATSAPP') ?? ''),
            'PRINCIPAL' => $this->request->getPost('PRINCIPAL') ? 1 : 0,
        ];

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar contato.');
            }

            return redirect()->to(route_to('admin.empresas.contatos', $empresaUuid))
                ->with('success', 'Contato atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar contato.');
        }

        return redirect()->to(route_to('admin.empresas.contatos', $empresaUuid))
            ->with('success', 'Contato criado com sucesso.');
    }

    public function excluir(string $empresaUuid, int $contatoId): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $model = model(EmpresaContatoModel::class);
        $item = $model->find($contatoId);

        if ($item === null || (int) $item->EMPRESA_ID !== $empresa->id) {
            return redirect()->back()
                ->with('error', 'Contato não encontrado.');
        }

        $model->delete($contatoId);

        return redirect()->to(route_to('admin.empresas.contatos', $empresaUuid))
            ->with('success', 'Contato excluído com sucesso.');
    }

}
