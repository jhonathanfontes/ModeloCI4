<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\ResponseInterface;
use App\Modulos\Seguranca\Rules\UsuarioRules;
use App\Modulos\Seguranca\Services\UsuarioService;
use App\Modulos\Sistema\Models\SituacaoModel;

class Usuarios extends BaseController
{
    private UsuarioService $usuarioService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->usuarioService = service('usuario');
    }

    public function index(): string
    {
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $result = $this->usuarioService->listar($perPage);

        return $this->render('Modulos/admin/usuarios/index', [
            'title'    => 'Usuários',
            'usuarios' => $result['itens'],
            'pager'    => $result['pager'],
            'success'  => session()->getFlashdata('success'),
            'error'    => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/admin/usuarios/form', [
            'title'     => 'Novo Usuário',
            'usuario'   => null,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(int $id): ResponseInterface|string
    {
        $usuario = $this->usuarioService->encontrar($id);

        if ($usuario === null) {
            return redirect()->to(route_to('admin.usuarios'))
                ->with('error', 'Usuário não encontrado.');
        }

        return $this->render('Modulos/admin/usuarios/form', [
            'title'     => 'Editar Usuário',
            'usuario'   => $usuario,
            'situacoes' => $this->listarSituacoes(),
            'success'   => session()->getFlashdata('success'),
            'error'     => session()->getFlashdata('error'),
            'errors'    => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_USUARIO') ?: 0);

        $rules = $id > 0 ? UsuarioRules::atualizacao() : UsuarioRules::cadastro();

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'NOME'        => $this->request->getPost('NOME'),
            'EMAIL'       => $this->request->getPost('EMAIL'),
            'TIPO'        => $this->request->getPost('TIPO'),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        if ($senha = $this->request->getPost('SENHA')) {
            $data['SENHA'] = $senha;
        }

        $data['ATUALIZADO_POR'] = 1;

        if ($id > 0) {
            $this->usuarioService->atualizar($id, $data);

            return redirect()->to(route_to('admin.usuarios'))
                ->with('success', 'Usuário atualizado com sucesso.');
        }

       // $data['CRIADO_POR'] = 1;

        $insertId = $this->usuarioService->criar($data);

        if ($insertId === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário. Verifique os dados.');
        }

        return redirect()->to(route_to('admin.usuarios'))
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function excluir(int $id): ResponseInterface
    {
        $usuario = $this->usuarioService->encontrar($id);

        if ($usuario === null) {
            return redirect()->back()
                ->with('error', 'Usuário não encontrado.');
        }

        $this->usuarioService->excluir($id);

        return redirect()->to(route_to('admin.usuarios'))
            ->with('success', 'Usuário cancelado com sucesso.');
    }

    private function listarSituacoes(): array
    {
        return model(SituacaoModel::class)
            ->where('MODULO', \App\Dominios\SituacaoRegistro::MODULO)
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();
    }
}
