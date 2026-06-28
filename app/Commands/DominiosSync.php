<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * @deprecated Use `sistema:situacao-sync` instead.
 */
class DominiosSync extends BaseCommand
{
    protected $group = 'Sistema';
    protected $name = 'dominios:sync';
    protected $description = '[DEPRECATED] Use sistema:situacao-sync.';

    public function run(array $params)
    {
        CLI::write('Este comando foi substituído por sistema:situacao-sync.', 'red');

        $this->call('sistema:situacao-sync', $params);
    }
}
