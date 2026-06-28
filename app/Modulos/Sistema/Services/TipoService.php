<?php

namespace App\Modulos\Sistema\Services;

use App\Dominios\TipoRegistro;

class TipoService
{
    public function sync(): int
    {
        $model = model('App\Modulos\Sistema\Models\TipoModel');

        $agora = date('Y-m-d H:i:s');
        $total = 0;

        foreach (TipoRegistro::dadosBanco() as $dado) {
            $existing = $model
                ->where('MODULO', $dado['MODULO'])
                ->where('CODIGO', $dado['CODIGO'])
                ->first();

            $dado['ATUALIZADO_EM'] = $agora;

            if ($existing !== null) {
                unset($dado['UUID'], $dado['ID_TIPO']);
                $dado['SITUACAO_ID'] = (int) $dado['SITUACAO_ID'];
                $model->update($existing->ID_TIPO, $dado);
            } else {
                $dado['CRIADO_EM'] = $agora;
                $dado['SITUACAO_ID'] = (int) $dado['SITUACAO_ID'];
                $model->insert($dado);
            }

            $total++;
        }

        return $total;
    }
}
