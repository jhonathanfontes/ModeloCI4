<?php

namespace App\Modulos\Cadastro\Rules;

class ClienteRules
{
    public static function cadastro(): array
    {
        return [
            'EMPRESA_ID' => [
                'label' => 'Empresa',
                'rules' => 'required|integer|is_not_unique[EMPRESAS.ID_EMPRESA]',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'NOME_FANTASIA' => [
                'label' => 'Nome Fantasia',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo',
                'rules' => 'required|integer|is_not_unique[SIST_TIPOS.ID_TIPO]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|integer|is_not_unique[SIST_SITUACOES.ID_SITUACAO]',
            ],
        ];
    }

    public static function endereco(): array
    {
        return [
            'CLIENTE_ID' => [
                'label' => 'Cliente',
                'rules' => 'required|integer|is_not_unique[CLIENTES.ID_CLIENTE]',
            ],
            'TIPO_ID' => [
                'label' => 'Tipo de Endereço',
                'rules' => 'required|integer|is_not_unique[SIST_TIPOS.ID_TIPO]',
            ],
            'CEP' => [
                'label' => 'CEP',
                'rules' => 'required|exact_length[8]',
            ],
            'LOGRADOURO' => [
                'label' => 'Logradouro',
                'rules' => 'required|max_length[255]',
            ],
            'NUMERO' => [
                'label' => 'Número',
                'rules' => 'required|max_length[20]',
            ],
            'COMPLEMENTO' => [
                'label' => 'Complemento',
                'rules' => 'permit_empty|max_length[100]',
            ],
            'BAIRRO' => [
                'label' => 'Bairro',
                'rules' => 'required|max_length[120]',
            ],
            'CIDADE' => [
                'label' => 'Cidade',
                'rules' => 'required|max_length[120]',
            ],
            'UF' => [
                'label' => 'UF',
                'rules' => 'required|exact_length[2]',
            ],
        ];
    }

    public static function contato(): array
    {
        return [
            'CLIENTE_ID' => [
                'label' => 'Cliente',
                'rules' => 'required|integer|is_not_unique[CLIENTES.ID_CLIENTE]',
            ],
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
                'rules' => 'required|integer|is_not_unique[SIST_SITUACOES.ID_SITUACAO]',
            ],
        ];
    }
}
