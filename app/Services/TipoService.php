<?php

namespace App\Services;

use App\Modulos\Sistema\Services\TipoService as ModuloTipoService;

class TipoService
{
    public static function create(): ModuloTipoService
    {
        return new ModuloTipoService();
    }
}
