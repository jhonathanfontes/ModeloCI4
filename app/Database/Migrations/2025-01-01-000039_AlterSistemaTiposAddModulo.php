<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSistemaTiposAddModulo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('SIST_TIPOS', [
            'MODULO' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'UUID',
                'comment' => 'Agrupador do contexto do tipo (ex: TIPO_PESSOA, TIPO_ENDERECO)',
            ],
        ]);

        $this->db->table('SIST_TIPOS')->update(['MODULO' => 'GERAL']);

        $this->forge->modifyColumn('SIST_TIPOS', [
            'MODULO' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
        ]);

        $this->forge->dropColumn('SIST_TIPOS', 'MODULO_ID');
    }

    public function down()
    {
        $this->forge->addColumn('SIST_TIPOS', [
            'MODULO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira vinculada ao módulo na tabela MENU_MODULOS',
            ],
        ]);

        $this->forge->dropColumn('SIST_TIPOS', 'MODULO');
    }
}
