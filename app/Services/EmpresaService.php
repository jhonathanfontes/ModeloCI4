<?php

namespace App\Services;

use App\Modulos\Cadastro\Services\EmpresaService as ModuloEmpresaService;

class EmpresaService
{
    public static function create(): ModuloEmpresaService
    {
        return new ModuloEmpresaService();
    }
}
