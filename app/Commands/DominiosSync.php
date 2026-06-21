<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DominiosSync extends BaseCommand
{
    protected $group       = 'Dominios';
    protected $name        = 'dominios:sync';
    protected $description = 'Sincroniza as situações dos domínios com a tabela SIST_SITUACOES.';

    public function run(array $params)
    {
        $service = service('situacao');

        CLI::write('Sincronizando domínios com SIST_SITUACOES...', 'yellow');

        $total = $service->sync();

        CLI::write("Pronto! {$total} situações sincronizadas.", 'green');
    }
}
