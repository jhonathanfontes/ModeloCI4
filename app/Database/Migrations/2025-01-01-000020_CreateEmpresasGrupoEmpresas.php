<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasGrupoEmpresas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_GRUPO_EMPRESA' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do vínculo (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)',
            ],
            'GRUPO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira para EMPR_GRUPOS',
            ],
            'EMPRESA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira para EMPRESAS',
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

        $this->forge->addKey('ID_GRUPO_EMPRESA', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey(['GRUPO_ID', 'EMPRESA_ID']);
        $this->forge->addForeignKey('GRUPO_ID', 'EMPR_GRUPOS', 'ID_GRUPO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPR_GRUPO_EMPRESAS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPR_GRUPO_EMPRESAS');
    }
}
