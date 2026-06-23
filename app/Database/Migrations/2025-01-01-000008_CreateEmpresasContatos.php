<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasContatos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_CONTATO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do contato (PK)',
            ],
            'UUID' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'comment' => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'EMPRESA_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira vinculada à empresa responsável na tabela EMPRESAS',
            ],
            'EMPRESA_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira vinculada à empresa na tabela EMPRESAS',
            ],
            'NOME' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'comment' => 'Nome do contato ou descrição do setor',
            ],
            'CARGO' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Cargo do contato na empresa',
            ],
            'TELEFONE' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
                'comment' => 'Telefone fixo com DDD, apenas números',
            ],
            'EMAIL' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'E-mail de contato',
            ],
            'WHATSAPP' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
                'comment' => 'Número de WhatsApp com DDD, apenas números',
            ],
            'PRINCIPAL' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Indica se é o contato principal (1) ou secundário (0)',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora exata de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora da última modificação efetuada',
            ],
            'EXCLUIDO_EM' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data de exclusão lógica (Soft Delete). Se nulo, o registro está ativo',
            ],
            'CRIADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário responsável pela criação do registro',
            ],
            'ATUALIZADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do último usuário responsável por atualizar o registro',
            ],
            'EXCLUIDO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário executor da exclusão lógica do registro',
            ],
        ]);

        $this->forge->addKey('ID_CONTATO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPR_CONTATOS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPR_CONTATOS');
    }
}
