<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasGrupos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_GRUPO' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do grupo (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nome do grupo (ex: Matriz, Filial Sudeste)',
            ],
            'DESCRICAO' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Descrição detalhada do grupo',
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

        $this->forge->addKey('ID_GRUPO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPR_GRUPOS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPR_GRUPOS');
    }
}
