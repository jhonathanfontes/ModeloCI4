<?php

namespace App\Controllers\Painel;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\Models\FornecedorModel;
use App\Modulos\Sistema\Models\SituacaoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Fornecedores extends BaseController
{
    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/fornecedores/index', [
                'title' => 'Fornecedores',
                'itens' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $model = model(FornecedorModel::class);
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $rows = $model->comSituacao()
            ->where('FORNECEDORES.EMPRESA_ID', (int) $empresaAtiva['id'])
            ->orderBy('FORNECEDORES.NOME', 'ASC')
            ->paginate($perPage);

        return $this->render('Modulos/painel/fornecedores/index', [
            'title' => 'Fornecedores',
            'itens' => $rows,
            'pager' => $model->pager,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/fornecedores/form', [
            'title' => 'Novo Fornecedor',
            'item' => null,
            'situacoes' => $this->listarSituacoes(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(int $id): ResponseInterface|string
    {
        $model = model(FornecedorModel::class);
        $item = $model->comSituacao()->find($id);

        if ($item === null) {
            return redirect()->to(route_to('painel.fornecedores'))
                ->with('error', 'Fornecedor não encontrado.');
        }

        return $this->render('Modulos/painel/fornecedores/form', [
            'title' => 'Editar Fornecedor',
            'item' => $item,
            'situacoes' => $this->listarSituacoes(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return redirect()->back()->with('error', 'Selecione uma empresa primeiro.');
        }

        $id = (int) ($this->request->getPost('ID_FORNECEDOR') ?: 0);
        $model = model(FornecedorModel::class);

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'NOME' => $this->request->getPost('NOME'),
            'CPF_CNPJ' => preg_replace('/\D/', '', $this->request->getPost('CPF_CNPJ') ?? ''),
            'EMAIL' => $this->request->getPost('EMAIL'),
            'TELEFONE' => preg_replace('/\D/', '', $this->request->getPost('TELEFONE') ?? ''),
            'CELULAR' => preg_replace('/\D/', '', $this->request->getPost('CELULAR') ?? ''),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar fornecedor.');
            }

            return redirect()->to(route_to('painel.fornecedores'))
                ->with('success', 'Fornecedor atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar fornecedor.');
        }

        return redirect()->to(route_to('painel.fornecedores'))
            ->with('success', 'Fornecedor criado com sucesso.');
    }

    public function excluir(int $id): ResponseInterface
    {
        $model = model(FornecedorModel::class);
        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);

        return redirect()->to(route_to('painel.fornecedores'))
            ->with('success', 'Fornecedor cancelado com sucesso.');
    }

    private function listarSituacoes(): array
    {
        return model(SituacaoModel::class)
            ->where('MODULO', SituacaoRegistro::MODULO)
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();
    }
}
