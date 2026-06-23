<?php

namespace App\Modulos\Sistema\Services;

use App\Dominios\Dominio;

class SituacaoService
{
    public function getId(string $modulo, string $codigo): ?int
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');

        $row = $model
            ->where('MODULO', $modulo)
            ->where('CODIGO', $codigo)
            ->first();

        return $row !== null ? (int) $row->ID_SITUACAO : null;
    }

    public function getIds(string $modulo, array $codigos): array
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');

        $rows = $model
            ->where('MODULO', $modulo)
            ->whereIn('CODIGO', $codigos)
            ->findAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row->CODIGO] = (int) $row->ID_SITUACAO;
        }

        return $result;
    }

    public function sync(): int
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');

        $agora = date('Y-m-d H:i:s');
        $total = 0;

        foreach (Dominio::classes() as $classe) {
            foreach ($classe::dadosBanco() as $dado) {
                $existing = $model
                    ->where('MODULO', $dado['MODULO'])
                    ->where('CODIGO', $dado['CODIGO'])
                    ->first();

                $dado['ATUALIZADO_EM'] = $agora;

                if ($existing !== null) {
                    $model->update($existing->ID_SITUACAO, $dado);
                } else {
                    $dado['CRIADO_EM'] = $agora;
                    $model->insert($dado);
                }

                $total++;
            }
        }

        return $total;
    }
}
