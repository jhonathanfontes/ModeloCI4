<?php

namespace App\Services;

use App\Modulos\Seguranca\Services\UsuarioService as ModuloUsuarioService;

class UsuarioService
{
    public static function create(): ModuloUsuarioService
    {
        return new ModuloUsuarioService();
    }
}
