<?php

namespace App\Modulos\Cadastro\Rules;

class FuncionarioRules
{
    public static function cadastro(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            'CARGO' => [
                'label' => 'Cargo',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'TELEFONE' => [
                'label' => 'Telefone',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'DEPARTAMENTO_ID' => [
                'label' => 'Departamento',
                'rules' => 'permit_empty|integer|is_not_unique[ORGA_DEPARTAMENTOS.ID_DEPARTAMENTO]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
