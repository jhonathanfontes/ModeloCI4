<?php

namespace App\Controllers\Painel;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\Services\ClienteService;
use App\Modulos\Sistema\Models\SituacaoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Clientes extends BaseController
{
    private ClienteService $clienteService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->clienteService = service('cliente');
    }

    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/clientes/index', [
                'title' => 'Clientes',
                'clientes' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $perPage = (int) ($this->request->getGet('per_page') ?: 20);
        $result = $this->clienteService->listar((int) $empresaAtiva['id'], $perPage);

        return $this->render('Modulos/painel/clientes/index', [
            'title' => 'Clientes',
            'clientes' => $result['itens'],
            'pager' => $result['pager'],
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/clientes/form', [
            'title' => 'Novo Cliente',
            'cliente' => null,
            'situacoes' => $this->listarSituacoes(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(int $id): ResponseInterface|string
    {
        $cliente = $this->clienteService->encontrar($id);

        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))
                ->with('error', 'Cliente não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/form', [
            'title' => 'Editar Cliente',
            'cliente' => $cliente,
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

        $id = (int) ($this->request->getPost('ID_CLIENTE') ?: 0);

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'NOME' => $this->request->getPost('NOME'),
            'NOME_FANTASIA' => $this->request->getPost('NOME_FANTASIA'),
            'TIPO_ID' => (int) ($this->request->getPost('TIPO_ID') ?: 0),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            if (! $this->clienteService->atualizar($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar cliente.');
            }

            return redirect()->to(route_to('painel.clientes'))
                ->with('success', 'Cliente atualizado com sucesso.');
        }

        $insertId = $this->clienteService->criar($data);

        if ($insertId === null) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar cliente.');
        }

        return redirect()->to(route_to('painel.clientes'))
            ->with('success', 'Cliente criado com sucesso.');
    }

    public function excluir(int $id): ResponseInterface
    {
        $this->clienteService->excluir($id);

        return redirect()->to(route_to('painel.clientes'))
            ->with('success', 'Cliente cancelado com sucesso.');
    }

    private function listarSituacoes(): array
    {
        return model(SituacaoModel::class)
            ->where('MODULO', SituacaoRegistro::MODULO)
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();
    }
}
