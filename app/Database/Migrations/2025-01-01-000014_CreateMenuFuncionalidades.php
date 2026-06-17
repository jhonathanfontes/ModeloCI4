<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuFuncionalidades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_FUNCIONALIDADE' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial da funcionalidade (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)',
            ],
            'SERVICO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira para MENU_SERVICOS',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nome amigável da funcionalidade',
            ],
            'DESCRICAO' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Descrição detalhada da funcionalidade',
            ],
            'CHAVE' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Identificador textual único no formato servico.acao (ex: cliente.criar)',
            ],
            'SITUACAO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira para SIST_SITUACOES',
            ],
            'CRIADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora da última modificação',
            ],
            'EXCLUIDO_EM' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data de exclusão lógica (Soft Delete)',
            ],
            'CRIADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário que criou o registro',
            ],
            'ATUALIZADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do último usuário que alterou o registro',
            ],
            'EXCLUIDO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário que executou a exclusão lógica',
            ],
        ]);

        $this->forge->addKey('ID_FUNCIONALIDADE', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey('CHAVE');
        $this->forge->addForeignKey('SERVICO_ID', 'MENU_SERVICOS', 'ID_SERVICO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('MENU_FUNCIONALIDADES');
    }

    public function down()
    {
        $this->forge->dropTable('MENU_FUNCIONALIDADES');
    }
}
