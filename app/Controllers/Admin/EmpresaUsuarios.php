<?php

namespace App\Controllers\Admin;

use App\Modulos\Cadastro\Services\EmpresaService;
use App\Modulos\Seguranca\Repositories\UsuarioRepository;
use CodeIgniter\HTTP\ResponseInterface;

class EmpresaUsuarios extends BaseController
{
    private EmpresaService $empresaService;
    private UsuarioRepository $usuarioRepository;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->empresaService = service('empresa');
        $this->usuarioRepository = service('usuarioRepository');
    }

    public function index(string $empresaUuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $usuarios = $this->usuarioRepository->usuariosDaEmpresa($empresa->id);
        $perfis = $this->usuarioRepository->listarPerfis();

        return $this->render('Modulos/admin/empresas/usuarios', [
            'title' => 'Usuários - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'usuarios' => $usuarios,
            'perfis' => $perfis,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function vincular(string $empresaUuid): ResponseInterface|string
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $usuariosDisponiveis = $this->usuarioRepository->usuariosDisponiveis($empresa->id);
        $perfis = $this->usuarioRepository->listarPerfis();

        return $this->render('Modulos/admin/empresas/usuarios_vincular', [
            'title' => 'Vincular Usuário - ' . $empresa->nomeFantasia,
            'empresa' => $empresa,
            'usuarios' => $usuariosDisponiveis,
            'perfis' => $perfis,
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

        $usuarioId = (int) $this->request->getPost('USUARIO_ID');
        $perfilId = $this->request->getPost('PERFIL_ID') ? (int) $this->request->getPost('PERFIL_ID') : null;

        if ($usuarioId <= 0) {
            return redirect()->back()
                ->with('error', 'Selecione um usuário para vincular.');
        }

        $dados = [
            'USUARIO_ID' => $usuarioId,
            'EMPRESA_ID' => $empresa->id,
        ];

        if ($perfilId !== null) {
            $dados['PERFIL_ID'] = $perfilId;
        }

        $insertId = $this->usuarioRepository->vincularEmpresa($dados);

        if ($insertId === null) {
            return redirect()->back()
                ->with('error', 'Erro ao vincular usuário. Verifique se já não está vinculado.');
        }

        return redirect()->to(route_to('admin.empresas.usuarios', $empresaUuid))
            ->with('success', 'Usuário vinculado com sucesso.');
    }

    public function desvincular(string $empresaUuid, int $vinculoId): ResponseInterface
    {
        $empresa = $this->empresaService->encontrarPorUuid($empresaUuid);

        if ($empresa === null) {
            return redirect()->to(route_to('admin.empresas'))
                ->with('error', 'Empresa não encontrada.');
        }

        $this->usuarioRepository->desvincularEmpresa($vinculoId);

        return redirect()->to(route_to('admin.empresas.usuarios', $empresaUuid))
            ->with('success', 'Usuário desvinculado com sucesso.');
    }
}
