<?php

namespace App\Services;

use App\Modulos\Menu\Services\MenuService as ModuloMenuService;

class MenuService
{
    public static function create(): ModuloMenuService
    {
        return new ModuloMenuService();
    }
}
