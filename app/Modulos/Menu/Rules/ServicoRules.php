<?php

namespace App\Modulos\Menu\Rules;

class ServicoRules
{
    public static function cadastro(): array
    {
        return [
            'MODULO_ID' => [
                'label' => 'Módulo',
                'rules' => 'required|integer|is_not_unique[MENU_MODULOS.ID_MODULO]',
            ],
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[100]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'permit_empty',
            ],
            'URL_MODULO' => [
                'label' => 'URL do Módulo',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'URL_ROTA' => [
                'label' => 'URL da Rota',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'ICONE' => [
                'label' => 'Ícone',
                'rules' => 'permit_empty|max_length[50]',
            ],
            'ORDEM' => [
                'label' => 'Ordem',
                'rules' => 'permit_empty|integer',
            ],
            'DASHBOARD' => [
                'label' => 'Dashboard',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO_ID' => [
                'label' => 'Situação',
                'rules' => 'required|integer|is_not_unique[SIST_SITUACOES.ID_SITUACAO]',
            ],
        ];
    }
}
