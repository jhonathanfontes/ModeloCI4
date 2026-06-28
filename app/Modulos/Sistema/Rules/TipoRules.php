<?php

namespace App\Modulos\Sistema\Rules;

class TipoRules
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
                'rules' => 'required|max_length[50]|is_unique[SIST_TIPOS.CODIGO]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'required|max_length[255]',
            ],
            'ORDEM' => [
                'label' => 'Ordem',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|max_length[50]',
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
                'rules' => 'required|max_length[50]|is_unique[SIST_TIPOS.CODIGO,ID_TIPO,' . $id . ']',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'required|max_length[255]',
            ],
            'ORDEM' => [
                'label' => 'Ordem',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|max_length[50]',
            ],
        ];
    }
}
