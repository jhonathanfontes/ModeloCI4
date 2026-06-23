<?php

namespace App\Services;

use App\Modulos\Planos\Services\PlanoService as ModuloPlanoService;

class PlanoService
{
    public static function create(): ModuloPlanoService
    {
        return new ModuloPlanoService();
    }
}
