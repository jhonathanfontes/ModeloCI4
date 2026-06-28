<?php

namespace App\Modulos\Cadastro\Rules;

class ClienteRules
{
    public static function cadastro(): array
    {
        return [
            'CPF_CNPJ' => [
                'label' => 'CPF/CNPJ',
                'rules' => 'permit_empty|max_length[14]',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'NOME_FANTASIA' => [
                'label' => 'Nome Fantasia',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'DATA_NASCIMENTO' => [
                'label' => 'Data de Nascimento',
                'rules' => 'permit_empty|valid_date',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'required|max_length[50]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }

    public static function endereco(): array
    {
        return [
            'TIPO_ID' => [
                'label' => 'Tipo de Endereço',
                'rules' => 'required|max_length[50]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }

    public static function contato(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome do Contato',
                'rules' => 'required|max_length[150]',
            ],
            'CARGO' => [
                'label' => 'Cargo',
                'rules' => 'permit_empty|max_length[100]',
            ],
            'TELEFONE' => [
                'label' => 'Telefone',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'permit_empty|valid_email|max_length[255]',
            ],
            'WHATSAPP' => [
                'label' => 'WhatsApp',
                'rules' => 'permit_empty|max_length[15]',
            ],
        ];
    }

    public static function usuario(): array
    {
        return [
            'PESSOA_ID' => [
                'label' => 'Pessoa',
                'rules' => 'required|integer|is_not_unique[PESSOAS.ID_PESSOA]',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]|is_unique[CLIE_USUARIO.EMAIL]',
            ],
            'SENHA' => [
                'label' => 'Senha',
                'rules' => 'required|min_length[8]|max_length[100]',
            ],
            'TELEFONE' => [
                'label' => 'Telefone',
                'rules' => 'permit_empty|max_length[15]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
