<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresaServicos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_EMPRESA_SERVICO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do vínculo empresa-serviço (PK)',
            ],
            'UUID' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'comment' => 'Identificador único público universal (UUID4)',
            ],
            'EMPRESA_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira para EMPRESAS',
            ],
            'SERVICO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira para MENU_SERVICOS',
            ],
            'ATIVO' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => 'Indica se o serviço está ativo (1) ou inativo (0) para esta empresa',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora da última modificação',
            ],
            'EXCLUIDO_EM' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data de exclusão lógica (Soft Delete)',
            ],
            'CRIADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário que criou o registro',
            ],
            'ATUALIZADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do último usuário que alterou o registro',
            ],
            'EXCLUIDO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário que executou a exclusão lógica',
            ],
        ]);

        $this->forge->addKey('ID_EMPRESA_SERVICO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey(['EMPRESA_ID', 'SERVICO_ID']);
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SERVICO_ID', 'MENU_SERVICOS', 'ID_SERVICO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPR_EMPRESA_SERVICOS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPR_EMPRESA_SERVICOS');
    }
}
