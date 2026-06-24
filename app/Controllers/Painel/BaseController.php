<?php

namespace App\Controllers\Painel;

use App\Modulos\Menu\Services\MenuService;
use Twig\Environment;

abstract class BaseController extends \App\Controllers\BaseController
{
    protected Environment $twig;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->twig = service('twig');
    }

    protected function render(string $template, array $data = []): string
    {
        $session = service('session');

        $flashData = $session->getFlashdata();
        foreach ($flashData as $key => $value) {
            if (! isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        if (! isset($data['usuario'])) {
            $data['usuario'] = $session->get('usuario');
        }

        if (! isset($data['empresaAtiva'])) {
            $data['empresaAtiva'] = $session->get('empresaAtiva');
        }

        if (! isset($data['menuModulos'])) {
            $empresaAtiva = $data['empresaAtiva'] ?? null;

            if ($empresaAtiva !== null && isset($empresaAtiva['id'])) {
                $menuService = new MenuService();
                $data['menuModulos'] = $menuService->montarMenuPainel((int) $empresaAtiva['id']);
            } else {
                $data['menuModulos'] = [];
            }
        }

        if (! isset($data['moduloAtivo'])) {
            $data['moduloAtivo'] = 'painel';
        }

        if (! isset($data['currentRoute'])) {
            $matchedRoute = service('router')->getMatchedRoute();
            $data['currentRoute'] = $matchedRoute['name'] ?? '';
        }

        return $this->twig->render($template, $data);
    }
}
