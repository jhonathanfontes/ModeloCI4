<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientesUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_CLIE_USUARIO' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do usuário cliente (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'PESSOA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira vinculada à pessoa na tabela PESSOAS (CPF/CNPJ do cadastro)',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nome completo do usuário cliente',
            ],
            'EMAIL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'E-mail de login do usuário cliente (UNIQUE)',
            ],
            'SENHA_HASH' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Hash da senha armazenado com algoritmo BCRYPT',
            ],
            'TELEFONE' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
                'comment'    => 'Telefone de contato com DDD, apenas números',
            ],
            'SITUACAO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira vinculada ao estado atual na tabela SIST_SITUACOES',
            ],
            'CRIADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora exata de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora da última modificação efetuada',
            ],
            'EXCLUIDO_EM' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data de exclusão lógica (Soft Delete). Se nulo, o registro está ativo',
            ],
            'CRIADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário responsável pela criação do registro',
            ],
            'ATUALIZADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do último usuário responsável por atualizar o registro',
            ],
            'EXCLUIDO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário executor da exclusão lógica do registro',
            ],
        ]);

        $this->forge->addKey('ID_CLIE_USUARIO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey('EMAIL');
        $this->forge->addForeignKey('CLIENTE_ID', 'CLIENTES', 'ID_CLIENTE', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('PESSOA_ID', 'PESSOAS', 'ID_PESSOA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('CLIE_USUARIO');
    }

    public function down()
    {
        $this->forge->dropTable('CLIE_USUARIO');
    }
}
