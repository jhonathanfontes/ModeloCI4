<?php

namespace App\Services;

use App\Modulos\Seguranca\Repositories\UsuarioRepository;

class UsuarioRepositoryService
{
    public static function create(): UsuarioRepository
    {
        return new UsuarioRepository();
    }
}
