<?php

namespace App\Controllers\Painel;

use App\Modulos\Cadastro\Models\EmpresaModuloModel;
use App\Modulos\Cadastro\Models\EmpresaServicoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pagina extends BaseController
{
    public function modulo(string $modulo): string|ResponseInterface
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return redirect()->to(route_to('painel.dashboard'))
                ->with('error', 'Selecione uma empresa primeiro.');
        }

        $path = '/' . $modulo;

        $db = db_connect();

        $moduloData = $db->table('MENU_MODULOS')
            ->select('ID_MODULO, NOME, ICONE, DESCRICAO')
            ->where('URL_ROTA', $path)
            ->where('EXCLUIDO_EM', null)
            ->get()
            ->getRowArray();

        if ($moduloData === null) {
            return $this->render('Modulos/painel/pagina', [
                'title' => 'Página não encontrada',
                'pageTitle' => 'Página não encontrada',
                'pageIcon' => null,
                'pageDescription' => 'O módulo solicitado não foi encontrado.',
                'moduloNome' => $modulo,
            ]);
        }

        $moduloId = (int) $moduloData['ID_MODULO'];
        $moduloNome = $moduloData['NOME'];
        $moduloIcone = $moduloData['ICONE'];
        $moduloDescricao = $moduloData['DESCRICAO'];

        $temAcesso = model(EmpresaModuloModel::class)
            ->where('EMPRESA_ID', (int) $empresaAtiva['id'])
            ->where('MODULO_ID', $moduloId)
            ->where('ATIVO', 1)
            ->where('EXCLUIDO_EM', null)
            ->first();

        if ($temAcesso === null) {
            return redirect()->to(route_to('painel.dashboard'))
                ->with('error', 'Você não tem acesso a este módulo.');
        }

        $servicos = $db->table('MENU_SERVICOS')
            ->select('ID_SERVICO, NOME, ICONE, URL_ROTA, DESCRICAO')
            ->where('MODULO_ID', $moduloId)
            ->where('EXCLUIDO_EM', null)
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('NOME', 'ASC')
            ->get()
            ->getResultArray();

        $servicosPermitidos = [];

        if (! empty($servicos)) {
            $servicoIds = array_map(fn ($s) => (int) $s['ID_SERVICO'], $servicos);

            $ativos = $db->table('EMPR_EMPRESA_SERVICOS')
                ->select('SERVICO_ID')
                ->where('EMPRESA_ID', (int) $empresaAtiva['id'])
                ->whereIn('SERVICO_ID', $servicoIds)
                ->where('ATIVO', 1)
                ->where('EXCLUIDO_EM', null)
                ->get()
                ->getResultArray();

            $idsAtivos = array_map(fn ($a) => (int) $a['SERVICO_ID'], $ativos);

            foreach ($servicos as $s) {
                if (in_array((int) $s['ID_SERVICO'], $idsAtivos, true)) {
                    $servicosPermitidos[] = $s;
                }
            }
        }

        return $this->render('Modulos/painel/pagina', [
            'title' => $moduloNome . ' - Painel',
            'pageTitle' => $moduloNome,
            'pageIcon' => $moduloIcone,
            'pageDescription' => $moduloDescricao,
            'moduloNome' => $moduloNome,
            'servicos' => $servicosPermitidos,
        ]);
    }

    public function servico(string $modulo, string $acao): string|ResponseInterface
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return redirect()->to(route_to('painel.dashboard'))
                ->with('error', 'Selecione uma empresa primeiro.');
        }

        $path = '/' . $modulo . '/' . $acao;

        $db = db_connect();

        $servicoData = $db->table('MENU_SERVICOS')
            ->select('MENU_SERVICOS.ID_SERVICO, MENU_SERVICOS.NOME, MENU_SERVICOS.ICONE, MENU_SERVICOS.DESCRICAO, MENU_SERVICOS.MODULO_ID, MENU_MODULOS.NOME AS MODULO_NOME, MENU_MODULOS.ICONE AS MODULO_ICONE')
            ->join('MENU_MODULOS', 'MENU_MODULOS.ID_MODULO = MENU_SERVICOS.MODULO_ID')
            ->where('MENU_SERVICOS.URL_ROTA', $path)
            ->where('MENU_SERVICOS.EXCLUIDO_EM', null)
            ->get()
            ->getRowArray();

        if ($servicoData === null) {
            return $this->render('Modulos/painel/pagina', [
                'title' => 'Página não encontrada',
                'pageTitle' => 'Página não encontrada',
                'pageIcon' => null,
                'pageDescription' => 'O serviço solicitado não foi encontrado.',
                'moduloNome' => $modulo,
            ]);
        }

        $servicoId = (int) $servicoData['ID_SERVICO'];
        $moduloNome = $servicoData['MODULO_NOME'];
        $servicoNome = $servicoData['NOME'];
        $servicoIcone = $servicoData['ICONE'];
        $moduloIcone = $servicoData['MODULO_ICONE'];
        $servicoDescricao = $servicoData['DESCRICAO'];

        $temAcesso = model(EmpresaServicoModel::class)
            ->where('EMPRESA_ID', (int) $empresaAtiva['id'])
            ->where('SERVICO_ID', $servicoId)
            ->where('ATIVO', 1)
            ->where('EXCLUIDO_EM', null)
            ->first();

        if ($temAcesso === null) {
            return redirect()->to(route_to('painel.dashboard'))
                ->with('error', 'Você não tem acesso a este serviço.');
        }

        return $this->render('Modulos/painel/pagina', [
            'title' => $servicoNome . ' - ' . $moduloNome,
            'pageTitle' => $servicoNome,
            'pageIcon' => $servicoIcone ?? $moduloIcone,
            'pageDescription' => $servicoDescricao,
            'moduloNome' => $moduloNome,
            'servicoNome' => $servicoNome,
            'servico' => $servicoData,
        ]);
    }
}
