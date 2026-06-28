<?php

namespace App\Controllers\Painel;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\Models\ProdutoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Produtos extends BaseController
{
    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/produtos/index', [
                'title' => 'Produtos',
                'itens' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $model = model(ProdutoModel::class);
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $rows = $model->comSituacao()
            ->where('PRODUTOS.EMPRESA_ID', (int) $empresaAtiva['id'])
            ->orderBy('PRODUTOS.NOME', 'ASC')
            ->paginate($perPage);

        return $this->render('Modulos/painel/produtos/index', [
            'title' => 'Produtos',
            'itens' => $rows,
            'pager' => $model->pager,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/produtos/form', [
            'title' => 'Novo Produto',
            'item' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $model = model(ProdutoModel::class);
        $item = $model->comSituacao()->findByUuid($uuid);

        if ($item === null) {
            return redirect()->to(route_to('painel.produtos'))
                ->with('error', 'Produto não encontrado.');
        }

        return $this->render('Modulos/painel/produtos/form', [
            'title' => 'Editar Produto',
            'item' => $item,
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

        if (! $this->validate(\App\Modulos\Cadastro\Rules\ProdutoRules::cadastro())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (int) ($this->request->getPost('ID_PRODUTO') ?: 0);
        $model = model(ProdutoModel::class);

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'NOME' => $this->request->getPost('NOME'),
            'DESCRICAO' => $this->request->getPost('DESCRICAO'),
            'PRECO_CUSTO' => (float) ($this->request->getPost('PRECO_CUSTO') ?: 0),
            'PRECO_VENDA' => (float) ($this->request->getPost('PRECO_VENDA') ?: 0),
            'UNIDADE' => $this->request->getPost('UNIDADE'),
            'CODIGO_BARRAS' => preg_replace('/\D/', '', $this->request->getPost('CODIGO_BARRAS') ?? ''),
            'CODIGO_INTERNO' => $this->request->getPost('CODIGO_INTERNO'),
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'ESTOQUE' => (float) ($this->request->getPost('ESTOQUE') ?: 0),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar produto.');
            }

            return redirect()->to(route_to('painel.produtos'))
                ->with('success', 'Produto atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar produto.');
        }

        return redirect()->to(route_to('painel.produtos'))
            ->with('success', 'Produto criado com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $model = model(ProdutoModel::class);
        $item = $model->findByUuid($uuid);

        if ($item === null) {
            return redirect()->back()
                ->with('error', 'Produto não encontrado.');
        }

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        $model->update($item->ID_PRODUTO, ['SITUACAO_ID' => $situacaoCancelado]);

        return redirect()->to(route_to('painel.produtos'))
            ->with('success', 'Produto cancelado com sucesso.');
    }

}
