<?php

namespace App\Services;

use App\Modulos\Cadastro\Repositories\ClienteRepository;

class ClienteRepositoryService
{
    public static function create(): ClienteRepository
    {
        return new ClienteRepository();
    }
}
