<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SituacaoSync extends BaseCommand
{
    protected $group = 'Sistema';
    protected $name = 'sistema:situacao-sync';
    protected $description = 'Sincroniza as situações dos domínios com a tabela SIST_SITUACOES.';

    public function run(array $params)
    {
        $service = service('situacao');

        CLI::write('Sincronizando situações dos domínios com SIST_SITUACOES...', 'yellow');

        $total = $service->sync();

        CLI::write("Pronto! {$total} situações sincronizadas.", 'green');
    }
}
