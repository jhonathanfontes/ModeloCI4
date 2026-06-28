<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestDb extends BaseCommand
{
    protected $group = 'Test';
    protected $name = 'test:db';
    protected $description = 'Test insert client';

    public function run(array $params)
    {
        $service = service('cliente');
        $usuarioId = 1;

        CLI::write('--- TESTE 1: Cliente sem CPF/CNPJ ---', 'yellow');
        $cpfCnpj1 = '';
        $pessoaId1 = $service->findOrCreatePessoa($cpfCnpj1, null, $usuarioId);

        $data1 = [
            'EMPRESA_ID' => 1,
            'PESSOA_ID' => $pessoaId1,
            'NOME' => 'Cliente Sem Documento',
            'TIPO_ID' => 1,
            'SITUACAO_ID' => 1,
            'CRIADO_POR' => $usuarioId,
            'ATUALIZADO_POR' => $usuarioId,
        ];

        $insertId1 = $service->criar($data1);
        if ($insertId1 !== null) {
            CLI::write('Sucesso! ID: ' . $insertId1 . ' (PESSOA_ID: ' . var_export($pessoaId1, true) . ')', 'green');
        } else {
            CLI::error('Falha no Teste 1!');
            print_r(model(\App\Modulos\Cadastro\Models\ClienteModel::class)->errors());
        }

        CLI::write('--- TESTE 2: Cliente com CPF/CNPJ ---', 'yellow');
        $cpfCnpj2 = '12345678909';
        // Limpar pessoa existente com esse CPF se houver
        $db = \Config\Database::connect();
        $db->table('PESSOAS')->where('CPF_CNPJ', $cpfCnpj2)->delete();

        $pessoaId2 = $service->findOrCreatePessoa($cpfCnpj2, '1990-01-01', $usuarioId);

        $data2 = [
            'EMPRESA_ID' => 1,
            'PESSOA_ID' => $pessoaId2,
            'NOME' => 'Cliente Com Documento',
            'TIPO_ID' => 1,
            'SITUACAO_ID' => 1,
            'CRIADO_POR' => $usuarioId,
            'ATUALIZADO_POR' => $usuarioId,
        ];

        $insertId2 = $service->criar($data2);
        if ($insertId2 !== null) {
            CLI::write('Sucesso! ID: ' . $insertId2 . ' (PESSOA_ID: ' . var_export($pessoaId2, true) . ')', 'green');
        } else {
            CLI::error('Falha no Teste 2!');
            print_r(model(\App\Modulos\Cadastro\Models\ClienteModel::class)->errors());
            print_r(model(\App\Models\PessoaModel::class)->errors());
        }
    }
}
