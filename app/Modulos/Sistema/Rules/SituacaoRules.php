<?php

namespace App\Modulos\Sistema\Rules;

class SituacaoRules
{
    public static function cadastro(): array
    {
        return [
            'MODULO' => [
                'label' => 'Módulo',
                'rules' => 'required|max_length[100]',
            ],
            'CODIGO' => [
                'label' => 'Código',
                'rules' => 'required|max_length[50]|is_unique[SIST_SITUACOES.CODIGO]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'required|max_length[255]',
            ],
            'COR' => [
                'label' => 'Cor',
                'rules' => 'permit_empty|max_length[7]',
            ],
        ];
    }

    public static function atualizacao(int $id): array
    {
        return [
            'MODULO' => [
                'label' => 'Módulo',
                'rules' => 'required|max_length[100]',
            ],
            'CODIGO' => [
                'label' => 'Código',
                'rules' => 'required|max_length[50]|is_unique[SIST_SITUACOES.CODIGO,ID_SITUACAO,' . $id . ']',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'required|max_length[255]',
            ],
            'COR' => [
                'label' => 'Cor',
                'rules' => 'permit_empty|max_length[7]',
            ],
        ];
    }
}
