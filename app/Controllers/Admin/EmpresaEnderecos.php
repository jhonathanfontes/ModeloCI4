<?php

namespace App\Controllers\Admin;

use App\Modulos\Cadastro\Models\EmpresaEnderecoModel;
use App\Modulos\Cadastro\Services\EmpresaService;
use CodeIgniter\HTTP\ResponseInterface;

class EmpresaEnderecos extends BaseController
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

        $enderecos = model(EmpresaEnderecoModel::class)
            ->select('EMPR_ENDERECOS.*, SIST_TIPOS.DESCRICAO AS TIPO_NOME')
            ->join('SIST_TIPOS', 'SIST_TIPOS.ID_TIPO = EMPR_ENDERECOS.TIPO_ID', 'left')
            ->daEmpresa($empresa->id)
            ->orderBy('PRINCIPAL', 'DESC')
            ->orderBy('CRIADO_EM', 'ASC')
            ->findAll();

        return $this->render('Modulos/admin/empresas/enderecos', [
            'title' => 'Endereços - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'enderecos' => $enderecos,
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

        return $this->render('Modulos/admin/empresas/enderecos_form', [
            'title' => 'Novo Endereço - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'item' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $empresaUuid, int $enderecoId): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $item = model(EmpresaEnderecoModel::class)->find($enderecoId);

        if ($item === null || (int) $item->EMPRESA_ID !== $empresa->id) {
            return redirect()->to(route_to('admin.empresas.enderecos', $empresaUuid))
                ->with('error', 'Endereço não encontrado.');
        }

        return $this->render('Modulos/admin/empresas/enderecos_form', [
            'title' => 'Editar Endereço - ' . $empresa->nomeFantasia,
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

        $id = (int) ($this->request->getPost('ID_ENDERECO') ?: 0);
        $model = model(EmpresaEnderecoModel::class);

        $principal = $this->request->getPost('PRINCIPAL') ? 1 : 0;

        $data = [
            'EMPRESA_ID' => $empresa->id,
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'CEP' => preg_replace('/\D/', '', $this->request->getPost('CEP') ?? ''),
            'LOGRADOURO' => $this->request->getPost('LOGRADOURO'),
            'NUMERO' => $this->request->getPost('NUMERO'),
            'COMPLEMENTO' => $this->request->getPost('COMPLEMENTO'),
            'BAIRRO' => $this->request->getPost('BAIRRO'),
            'CIDADE' => $this->request->getPost('CIDADE'),
            'UF' => $this->request->getPost('UF'),
            'PRINCIPAL' => $principal,
        ];

        if ($principal) {
            $model->where('EMPRESA_ID', $empresa->id)
                ->where('ID_ENDERECO !=', $id > 0 ? $id : 0)
                ->set('PRINCIPAL', 0)
                ->update();
        }

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar endereço.');
            }

            return redirect()->to(route_to('admin.empresas.enderecos', $empresaUuid))
                ->with('success', 'Endereço atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar endereço.');
        }

        return redirect()->to(route_to('admin.empresas.enderecos', $empresaUuid))
            ->with('success', 'Endereço criado com sucesso.');
    }

    public function excluir(string $empresaUuid, int $enderecoId): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $model = model(EmpresaEnderecoModel::class);
        $item = $model->find($enderecoId);

        if ($item === null || (int) $item->EMPRESA_ID !== $empresa->id) {
            return redirect()->back()
                ->with('error', 'Endereço não encontrado.');
        }

        $model->delete($enderecoId);

        return redirect()->to(route_to('admin.empresas.enderecos', $empresaUuid))
            ->with('success', 'Endereço excluído com sucesso.');
    }


}
