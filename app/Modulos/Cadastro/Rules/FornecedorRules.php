<?php

namespace App\Modulos\Cadastro\Rules;

class FornecedorRules
{
    public static function cadastro(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'CPF_CNPJ' => [
                'label' => 'CPF/CNPJ',
                'rules' => 'permit_empty|min_length[11]|max_length[14]|regex_match[/^\d+$/]',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'permit_empty|valid_email|max_length[255]',
            ],
            'TELEFONE' => [
                'label' => 'Telefone',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'CELULAR' => [
                'label' => 'Celular',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
