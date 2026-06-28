<?php

namespace App\Modulos\Cadastro\Rules;

class ProdutoRules
{
    public static function cadastro(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'permit_empty|max_length[500]',
            ],
            'CODIGO_BARRAS' => [
                'label' => 'Código de Barras',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'CODIGO_INTERNO' => [
                'label' => 'Código Interno',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'PRECO_CUSTO' => [
                'label' => 'Preço de Custo',
                'rules' => 'permit_empty|decimal',
            ],
            'PRECO_VENDA' => [
                'label' => 'Preço de Venda',
                'rules' => 'required|decimal',
            ],
            'ESTOQUE' => [
                'label' => 'Estoque',
                'rules' => 'permit_empty|integer',
            ],
            'UNIDADE' => [
                'label' => 'Unidade',
                'rules' => 'permit_empty|max_length[10]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
