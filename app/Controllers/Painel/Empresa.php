<?php

namespace App\Controllers\Painel;

class Empresa extends BaseController
{
    public function ativar(int $empresaId)
    {
        $usuario = session('usuario');

        if ($usuario === null) {
            return redirect()->to(route_to('painel.login'));
        }

        $repo = service('usuarioRepository');
        $empresas = $repo->empresasDoUsuario($usuario['id']);

        $encontrada = null;
        foreach ($empresas as $e) {
            if ((int) $e->EMPRESA_ID === $empresaId) {
                $encontrada = $e;

                break;
            }
        }

        if ($encontrada === null) {
            return redirect()->to(route_to('painel.dashboard'))
                ->with('error', 'Empresa não encontrada ou sem vínculo.');
        }

        session()->set('empresaAtiva', [
            'id' => (int) $encontrada->EMPRESA_ID,
            'nome' => $encontrada->EMPRESA_NOME,
            'perfilNome' => $encontrada->PERFIL_NOME ?? '',
        ]);

        return redirect()->to(route_to('painel.dashboard'))
            ->with('success', 'Empresa ' . $encontrada->EMPRESA_NOME . ' selecionada.');
    }
}
