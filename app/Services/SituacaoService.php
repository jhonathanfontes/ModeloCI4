<?php

namespace App\Services;

use App\Modulos\Sistema\Services\SituacaoService as ModuloSituacaoService;

class SituacaoService
{
    public static function create(): ModuloSituacaoService
    {
        return new ModuloSituacaoService();
    }
}
