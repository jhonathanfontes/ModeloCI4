<?php

namespace App\Controllers\Painel;

use App\Modulos\Seguranca\Models\UsuarioModel;

class Login extends BaseController
{
    public function index(): string
    {
        if (session()->has('usuario')) {
            return redirect()->to(route_to('painel.dashboard'));
        }

        return $this->render('Modulos/painel/login', [
            'title' => 'Login',
        ]);
    }

    public function autenticar()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');
        $redirect = $this->request->getPost('redirect') ?? route_to('painel.dashboard');

        if (empty($email) || empty($senha)) {
            return redirect()->back()
                ->with('error', 'Informe e-mail e senha.')
                ->with('email', $email);
        }

        $usuario = model(UsuarioModel::class)->findByEmail($email);

        if ($usuario === null) {
            return redirect()->back()
                ->with('error', 'Usuário ou senha inválidos.')
                ->with('email', $email);
        }

        if (! password_verify($senha, $usuario->SENHA_HASH)) {
            return redirect()->back()
                ->with('error', 'Usuário ou senha inválidos.')
                ->with('email', $email);
        }

        $situacaoAtivo = service('situacao')->getId(
            \App\Dominios\SituacaoRegistro::MODULO,
            \App\Dominios\SituacaoRegistro::ATIVO
        );

        if ((int) $usuario->SITUACAO_ID !== $situacaoAtivo) {
            return redirect()->back()
                ->with('error', 'Usuário inativo ou bloqueado.')
                ->with('email', $email);
        }

        session()->set('usuario', [
            'id' => (int) $usuario->ID_USUARIO,
            'nome' => $usuario->NOME,
            'email' => $usuario->EMAIL,
            'tipo' => $usuario->TIPO,
        ]);

        model(UsuarioModel::class)->update($usuario->ID_USUARIO, [
            'ULTIMO_LOGIN' => date('Y-m-d H:i:s'),
            'ULTIMO_IP' => $this->request->getIPAddress(),
        ]);

        $repo = service('usuarioRepository');
        $empresas = $repo->empresasDoUsuario((int) $usuario->ID_USUARIO);

        $qtd = count($empresas);

        if ($qtd === 1) {
            $empresa = $empresas[0];
            session()->set('empresaAtiva', [
                'id' => (int) $empresa->EMPRESA_ID,
                'nome' => $empresa->EMPRESA_NOME,
                'perfilNome' => $empresa->PERFIL_NOME ?? '',
            ]);
        }

        return redirect()->to($redirect)
            ->with('success', 'Bem-vindo, ' . $usuario->NOME . '!');
    }

    public function sair()
    {
        session()->destroy();

        return redirect()->to(route_to('painel.login'))
            ->with('success', 'Sessão encerrada.');
    }
}
