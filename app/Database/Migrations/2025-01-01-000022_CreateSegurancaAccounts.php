<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSegurancaAccounts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_ACCOUNT' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial da conta (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)',
            ],
            'USUARIO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira para SEGU_USUARIOS',
            ],
            'USERNAME' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Nome de usuário para login (UNIQUE, pode ser nulo)',
            ],
            'EMAIL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'E-mail de login (UNIQUE)',
            ],
            'SENHA_HASH' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Hash da senha com BCrypt',
            ],
            'ULTIMO_LOGIN' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data e hora do último login bem-sucedido',
            ],
            'TENTATIVAS_FALHAS' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'default'    => 0,
                'comment'    => 'Contagem de tentativas de login consecutivas sem sucesso',
            ],
            'BLOQUEADO_EM' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data em que a conta foi bloqueada por segurança',
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

        $this->forge->addKey('ID_ACCOUNT', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey('USERNAME');
        $this->forge->addUniqueKey('EMAIL');
        $this->forge->addForeignKey('USUARIO_ID', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('SEGU_ACCOUNTS');
    }

    public function down()
    {
        $this->forge->dropTable('SEGU_ACCOUNTS');
    }
}
