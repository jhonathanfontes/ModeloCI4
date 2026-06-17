<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSistemaPlanos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_PLANO' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do plano (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nome do plano (ex: Básico, Premium)',
            ],
            'DESCRICAO' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Descrição detalhada dos recursos do plano',
            ],
            'VALOR' => [
                'type'        => 'DECIMAL',
                'constraint'  => '10,2',
                'comment'     => 'Valor mensal do plano em reais (BRL)',
            ],
            'PERIODO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'Chave estrangeira para SIST_TIPOS (ex: mensal, anual)',
            ],
            'LIMITE_CLIENTES' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Número máximo de clientes permitido (NULL = ilimitado)',
            ],
            'LIMITE_USUARIOS' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Número máximo de usuários permitido',
            ],
            'LIMITE_ARMAZENAMENTO_MB' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Limite de armazenamento em MB',
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

        $this->forge->addKey('ID_PLANO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('PERIODO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('SIST_PLANOS');
    }

    public function down()
    {
        $this->forge->dropTable('SIST_PLANOS');
    }
}
