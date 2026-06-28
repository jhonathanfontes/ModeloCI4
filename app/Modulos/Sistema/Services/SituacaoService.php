<?php

namespace App\Modulos\Sistema\Services;

use App\Dominios\SituacaoRegistro;

class SituacaoService
{
    private static array $idCache = [];

    public function getId(string $modulo, string $codigo): ?int
    {
        $key = $modulo . "\x00" . $codigo;

        if (array_key_exists($key, self::$idCache)) {
            return self::$idCache[$key];
        }

        $model = model('App\Modulos\Sistema\Models\SituacaoModel');
        $row = $model
            ->where('MODULO', $modulo)
            ->where('CODIGO', $codigo)
            ->first();

        if ($row === null) {
            return self::$idCache[$key] = null;
        }

        return self::$idCache[$key] = (int) $row->ID_SITUACAO;
    }

    public function getIds(string $modulo, array $codigos): array
    {
        if ($codigos === []) {
            return [];
        }

        $model = model('App\Modulos\Sistema\Models\SituacaoModel');
        $rows = $model
            ->where('MODULO', $modulo)
            ->whereIn('CODIGO', $codigos)
            ->findAll();

        $map = [];
        foreach ($rows as $row) {
            $key = $modulo . "\x00" . $row->CODIGO;
            self::$idCache[$key] = (int) $row->ID_SITUACAO;
            $map[$row->CODIGO] = (int) $row->ID_SITUACAO;
        }

        return $map;
    }

    public function sync(): int
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');

        $agora = date('Y-m-d H:i:s');
        $total = 0;

        foreach (SituacaoRegistro::dadosBanco() as $dado) {
            $existing = $model
                ->where('MODULO', $dado['MODULO'])
                ->where('CODIGO', $dado['CODIGO'])
                ->first();

            $dado['ATUALIZADO_EM'] = $agora;

            if ($existing !== null) {
                unset($dado['UUID'], $dado['ID_SITUACAO']);
                $model->update($existing->ID_SITUACAO, $dado);
            } else {
                $dado['CRIADO_EM'] = $agora;
                $model->insert($dado);
            }

            $total++;
        }

        return $total;
    }
}
