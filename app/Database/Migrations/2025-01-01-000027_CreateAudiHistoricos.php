<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAudiHistoricos extends Migration
{
    protected $DBGroup = 'loggerDB';

    public function up()
    {
        $this->forge->addField([
            'ID_HISTORICO' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do histórico (PK)',
            ],
            'TABELA' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nome da tabela onde o campo foi alterado',
            ],
            'TABELA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'ID do registro na tabela de origem',
            ],
            'CAMPO' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nome da coluna que foi alterada',
            ],
            'VALOR_ANTERIOR' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Valor do campo antes da alteração',
            ],
            'VALOR_NOVO' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Valor do campo após a alteração',
            ],
            'USUARIO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário que realizou a alteração (referência lógica)',
            ],
            'CRIADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora exata da alteração',
            ],
        ]);

        $this->forge->addKey('ID_HISTORICO', true);
        $this->forge->addKey('TABELA');
        $this->forge->addKey('TABELA_ID');
        $this->forge->addKey('CAMPO');
        $this->forge->addKey('USUARIO_ID');
        $this->forge->addKey('CRIADO_EM');
        $this->forge->createTable('AUDI_HISTORICOS');
    }

    public function down()
    {
        $this->forge->dropTable('AUDI_HISTORICOS');
    }
}
