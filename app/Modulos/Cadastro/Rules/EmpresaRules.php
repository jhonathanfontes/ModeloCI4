<?php

namespace App\Modulos\Cadastro\Rules;

class EmpresaRules
{
    public static function cadastro(): array
    {
        return [
            'RAZAO_SOCIAL' => [
                'label' => 'Razão Social',
                'rules' => 'required|max_length[255]',
            ],
            'NOME_FANTASIA' => [
                'label' => 'Nome Fantasia',
                'rules' => 'required|max_length[255]',
            ],
            'CPF_CNPJ' => [
                'label' => 'CPF/CNPJ',
                'rules' => 'required|min_length[11]|max_length[14]|regex_match[/^\d+$/]|is_unique[EMPRESAS.CPF_CNPJ]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]',
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
                'rules' => 'required|max_length[50]',
            ],
        ];
    }

    public static function atualizacao(?int $id = null): array
    {
        $cpfCnpjRule = 'required|min_length[11]|max_length[14]|regex_match[/^\d+$/]';
        if ($id !== null) {
            $cpfCnpjRule .= '|is_unique[EMPRESAS.CPF_CNPJ,ID_EMPRESA,' . $id . ']';
        }

        return [
            'RAZAO_SOCIAL' => [
                'label' => 'Razão Social',
                'rules' => 'required|max_length[255]',
            ],
            'NOME_FANTASIA' => [
                'label' => 'Nome Fantasia',
                'rules' => 'required|max_length[255]',
            ],
            'CPF_CNPJ' => [
                'label' => 'CPF/CNPJ',
                'rules' => $cpfCnpjRule,
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            'TELEFONE' => [
                'label' => 'Telefone',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'CELULAR' => [
                'label' => 'Celular',
                'rules' => 'permit_empty|max_length[15]',
            ],
        ];
    }
}
