<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TipoSync extends BaseCommand
{
    protected $group = 'Sistema';
    protected $name = 'sistema:tipos-sync';
    protected $description = 'Sincroniza os tipos dos domínios com a tabela SIST_TIPOS.';

    public function run(array $params)
    {
        $service = service('tipo');

        CLI::write('Sincronizando tipos dos domínios com SIST_TIPOS...', 'yellow');

        $total = $service->sync();

        CLI::write("Pronto! {$total} tipos sincronizados.", 'green');
    }
}
