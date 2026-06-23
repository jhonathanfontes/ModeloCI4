<?php

namespace App\Modulos\Planos\Rules;

class PlanoRules
{
    public static function cadastro(): array
    {
        return [
            'NOME' => [
                'label' => 'Nome',
                'rules' => 'required|max_length[100]',
            ],
            'DESCRICAO' => [
                'label' => 'Descrição',
                'rules' => 'permit_empty|max_length[500]',
            ],
            'VALOR' => [
                'label' => 'Valor',
                'rules' => 'required|decimal',
            ],
            'PERIODO_ID' => [
                'label' => 'Período',
                'rules' => 'permit_empty|integer|is_not_unique[SIST_TIPOS.ID_TIPO]',
            ],
            'LIMITE_CLIENTES' => [
                'label' => 'Limite de Clientes',
                'rules' => 'permit_empty|integer',
            ],
            'LIMITE_USUARIOS' => [
                'label' => 'Limite de Usuários',
                'rules' => 'permit_empty|integer',
            ],
            'LIMITE_ARMAZENAMENTO_MB' => [
                'label' => 'Limite de Armazenamento (MB)',
                'rules' => 'permit_empty|integer',
            ],
            'SITUACAO' => [
                'label' => 'Situação',
                'rules' => 'permit_empty|in_list[0,1]',
            ],
        ];
    }

    public static function atualizacao(?int $id = null): array
    {
        return self::cadastro();
    }
}
