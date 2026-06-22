<?php

namespace App\Controllers\Admin;

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
        return $this->twig->render($template, $data);
    }
}
