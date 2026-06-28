<?php

namespace App\Controllers\Painel;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\Models\ServicoOfertaModel;
use CodeIgniter\HTTP\ResponseInterface;

class ServicosCadastro extends BaseController
{
    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/servicos_cadastro/index', [
                'title' => 'Serviços',
                'itens' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $model = model(ServicoOfertaModel::class);
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $rows = $model->comSituacao()
            ->where('SERVICOS.EMPRESA_ID', (int) $empresaAtiva['id'])
            ->orderBy('SERVICOS.NOME', 'ASC')
            ->paginate($perPage);

        return $this->render('Modulos/painel/servicos_cadastro/index', [
            'title' => 'Serviços',
            'itens' => $rows,
            'pager' => $model->pager,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/servicos_cadastro/form', [
            'title' => 'Novo Serviço',
            'item' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $model = model(ServicoOfertaModel::class);
        $item = $model->comSituacao()->findByUuid($uuid);

        if ($item === null) {
            return redirect()->to(route_to('painel.servicos-cadastro'))
                ->with('error', 'Serviço não encontrado.');
        }

        return $this->render('Modulos/painel/servicos_cadastro/form', [
            'title' => 'Editar Serviço',
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

        if (! $this->validate(\App\Modulos\Cadastro\Rules\ServicoRules::cadastro())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (int) ($this->request->getPost('ID_SERVICO') ?: 0);
        $model = model(ServicoOfertaModel::class);

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'NOME' => $this->request->getPost('NOME'),
            'DESCRICAO' => $this->request->getPost('DESCRICAO'),
            'PRECO' => (float) ($this->request->getPost('PRECO') ?: 0),
            'DURACAO_MINUTOS' => $this->request->getPost('DURACAO_MINUTOS') ? (int) $this->request->getPost('DURACAO_MINUTOS') : null,
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar serviço.');
            }

            return redirect()->to(route_to('painel.servicos-cadastro'))
                ->with('success', 'Serviço atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar serviço.');
        }

        return redirect()->to(route_to('painel.servicos-cadastro'))
            ->with('success', 'Serviço criado com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $model = model(ServicoOfertaModel::class);
        $item = $model->findByUuid($uuid);

        if ($item === null) {
            return redirect()->back()
                ->with('error', 'Serviço não encontrado.');
        }

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        $model->update($item->ID_SERVICO, ['SITUACAO_ID' => $situacaoCancelado]);

        return redirect()->to(route_to('painel.servicos-cadastro'))
            ->with('success', 'Serviço cancelado com sucesso.');
    }

}
