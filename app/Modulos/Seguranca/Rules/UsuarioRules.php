<?php

namespace App\Modulos\Seguranca\Rules;

class UsuarioRules
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
                'rules' => 'required|valid_email|max_length[255]|is_unique[SEGU_USUARIOS.EMAIL]',
            ],
            'SENHA' => [
                'label' => 'Senha',
                'rules' => 'required|min_length[8]|max_length[100]',
            ],
            'TIPO' => [
                'label' => 'Tipo',
                'rules' => 'required|in_list[SYSTEM,EMPRESA,CLIENTE]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }

    public static function atualizacao(): array
    {
        return [
            'ID_USUARIO' => [
                'label' => 'ID do Usuário',
                'rules' => 'required|integer',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[255]',
            ],
            'EMAIL' => [
                'label' => 'E-mail',
                'rules' => 'required|valid_email|max_length[255]|is_unique[SEGU_USUARIOS.EMAIL,ID_USUARIO,{ID_USUARIO}]',
            ],
            'TIPO' => [
                'label' => 'Tipo',
                'rules' => 'required|in_list[SYSTEM,EMPRESA,CLIENTE]',
            ],
        ];
    }

    public static function vinculoEmpresa(): array
    {
        return [
            'USUARIO_ID' => [
                'label' => 'Usuário',
                'rules' => 'required|integer|is_not_unique[SEGU_USUARIOS.ID_USUARIO]',
            ],
            'EMPRESA_ID' => [
                'label' => 'Empresa',
                'rules' => 'required|integer|is_not_unique[EMPRESAS.ID_EMPRESA]',
            ],
            'PERFIL_ID' => [
                'label' => 'Perfil',
                'rules' => 'permit_empty|integer|is_not_unique[PERF_PERFIS.ID_PERFIL]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }

    public static function perfil(): array
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
            'NIVEL' => [
                'label' => 'Nível',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|string',
            ],
        ];
    }
}
