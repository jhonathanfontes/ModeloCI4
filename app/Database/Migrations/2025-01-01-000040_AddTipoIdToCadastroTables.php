<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoIdToCadastroTables extends Migration
{
    public function up()
    {
        // ── FORNECEDORES ─────────────────────────────────────────────
        $this->forge->addColumn('FORNECEDORES', [
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'CPF_CNPJ',
                'comment' => 'Chave estrangeira para SIST_TIPOS (ex: PF/PJ)',
            ],
        ]);
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');

        // ── FUNCIONARIOS ─────────────────────────────────────────────
        $this->forge->addColumn('FUNCIONARIOS', [
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'CARGO',
                'comment' => 'Chave estrangeira para SIST_TIPOS',
            ],
        ]);
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');

        // ── PRODUTOS ─────────────────────────────────────────────────
        $this->forge->addColumn('PRODUTOS', [
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'CODIGO_INTERNO',
                'comment' => 'Chave estrangeira para SIST_TIPOS (categoria)',
            ],
        ]);
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');

        // ── SERVICOS ─────────────────────────────────────────────────
        $this->forge->addColumn('SERVICOS', [
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'DURACAO_MINUTOS',
                'comment' => 'Chave estrangeira para SIST_TIPOS',
            ],
        ]);
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');

        // ── EMPR_CONTATOS ────────────────────────────────────────────
        $this->forge->addColumn('EMPR_CONTATOS', [
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'after' => 'CARGO',
                'comment' => 'Chave estrangeira para SIST_TIPOS',
            ],
        ]);
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->forge->dropForeignKey('FORNECEDORES', 'FORNECEDORES_TIPO_ID_foreign');
        $this->forge->dropColumn('FORNECEDORES', 'TIPO_ID');

        $this->forge->dropForeignKey('FUNCIONARIOS', 'FUNCIONARIOS_TIPO_ID_foreign');
        $this->forge->dropColumn('FUNCIONARIOS', 'TIPO_ID');

        $this->forge->dropForeignKey('PRODUTOS', 'PRODUTOS_TIPO_ID_foreign');
        $this->forge->dropColumn('PRODUTOS', 'TIPO_ID');

        $this->forge->dropForeignKey('SERVICOS', 'SERVICOS_TIPO_ID_foreign');
        $this->forge->dropColumn('SERVICOS', 'TIPO_ID');

        $this->forge->dropForeignKey('EMPR_CONTATOS', 'EMPR_CONTATOS_TIPO_ID_foreign');
        $this->forge->dropColumn('EMPR_CONTATOS', 'TIPO_ID');
    }
}
