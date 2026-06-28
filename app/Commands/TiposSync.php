<?php

namespace App\Commands;

use App\Dominios\SituacaoRegistro;
use App\Dominios\TipoRegistro;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TiposSync extends BaseCommand
{
    protected $group = 'Sistema';
    protected $name = 'sistema:tipos-sync';
    protected $description = 'Sincroniza os tipos padrões do sistema na tabela SIST_TIPOS.';

    public function run(array $params)
    {
        $db = db_connect();
        $agora = date('Y-m-d H:i:s');

        $situacaoAtiva = $db->table('SIST_SITUACOES')
            ->where('MODULO', 'SITUACAO_REGISTRO')
            ->where('CODIGO', SituacaoRegistro::ATIVO)
            ->get()->getRow();

        $situacaoId = $situacaoAtiva ? $situacaoAtiva->CODIGO : SituacaoRegistro::ATIVO;

        $tipos = TipoRegistro::dadosBanco();

        CLI::write('Sincronizando tipos padrões com SIST_TIPOS...', 'yellow');

        $total = 0;
        foreach ($tipos as $tipo) {
            $existing = $db->table('SIST_TIPOS')
                ->where('ID_TIPO', $tipo['ID_TIPO'])
                ->get()->getRow();

            $data = [
                'MODULO' => $tipo['MODULO'],
                'CODIGO' => $tipo['CODIGO'],
                'DESCRICAO' => $tipo['DESCRICAO'],
                'ORDEM' => $tipo['ORDEM'],
                'SITUACAO_ID' => $situacaoId,
                'ATUALIZADO_EM' => $agora,
            ];

            if ($existing !== null) {
                $db->table('SIST_TIPOS')
                    ->where('ID_TIPO', $tipo['ID_TIPO'])
                    ->update($data);
            } else {
                $data['ID_TIPO'] = $tipo['ID_TIPO'];
                $data['UUID'] = $tipo['UUID'];
                $data['CRIADO_EM'] = $agora;
                $db->table('SIST_TIPOS')->insert($data);
            }
            $total++;
        }

        CLI::write("Pronto! {$total} tipos sincronizados.", 'green');
    }
}
