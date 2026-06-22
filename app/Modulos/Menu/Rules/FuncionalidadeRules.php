<?php

namespace App\Modulos\Menu\Rules;

class FuncionalidadeRules
{
    public static function cadastro(): array
    {
        return [
            'SERVICO_ID' => [
                'label' => 'Serviço',
                'rules' => 'required|integer|is_not_unique[MENU_SERVICOS.ID_SERVICO]',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[100]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'permit_empty',
            ],
            'CHAVE' => [
                'label' => 'Chave',
                'rules' => 'required|max_length[100]|is_unique[MENU_FUNCIONALIDADES.CHAVE]',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|integer|is_not_unique[SIST_SITUACOES.ID_SITUACAO]',
            ],
        ];
    }
}
