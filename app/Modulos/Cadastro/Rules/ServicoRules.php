<?php

namespace App\Modulos\Cadastro\Rules;

class ServicoRules
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
            'PRECO' => [
                'label' => 'Preço',
                'rules' => 'required|decimal',
            ],
            'DURACAO_MINUTOS' => [
                'label' => 'Duração (minutos)',
                'rules' => 'permit_empty|integer',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
