<?php

namespace App\Controllers\Painel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        $empresas = [];

        if ($empresaAtiva === null) {
            $usuario = session('usuario');
            if ($usuario !== null) {
                $repo = service('usuarioRepository');
                $empresas = $repo->empresasDoUsuario((int) $usuario['id']);
            }
        }

        return $this->render('Modulos/painel/dashboard', [
            'title' => 'Dashboard',
            'empresas' => $empresas,
        ]);
    }
}
