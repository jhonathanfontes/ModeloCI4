<?php

namespace App\Modulos\Menu\Rules;

class ModuloRules
{
    public static function cadastro(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[100]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'permit_empty',
            ],
            'ICONE' => [
                'label' => 'Ícone',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'URL_ROTA' => [
                'label' => 'URL da Rota',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'ORDEM' => [
                'label' => 'Ordem',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
