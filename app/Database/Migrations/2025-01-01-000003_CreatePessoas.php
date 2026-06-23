<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePessoas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_PESSOA' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial da pessoa (PK)',
            ],
            'CPF_CNPJ' => [
                'type' => 'VARCHAR',
                'constraint' => 14,
                'comment' => 'CPF ou CNPJ apenas números (UNIQUE)',
            ],
            'DATA_NASCIMENTO' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Data de nascimento do cliente (pessoa física)',
            ],
            'EMAIL' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'E-mail de login do usuário (UNIQUE)',
            ],
            'SENHA_HASH' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Hash da senha armazenado com algoritmo BCRYPT',
            ],
            'ULTIMO_LOGIN' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data e hora do último login bem-sucedido',
            ],
            'ULTIMO_IP' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'comment' => 'Endereço IP do último acesso',
            ],
            'EMAIL_VERIFICADO_EM' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data de verificação do e-mail',
            ],
            'TENTATIVAS_LOGIN' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Contador de tentativas de login falhas consecutivas',
            ],
            'BLOQUEADO_ATE' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Bloqueio temporário por excesso de tentativas de login',
            ],
            'SITUACAO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira vinculada ao estado atual na tabela SIST_SITUACOES',
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

        $this->forge->addKey('ID_PESSOA', true);
        $this->forge->addUniqueKey('CPF_CNPJ');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PESSOAS');
    }

    public function down()
    {
        $this->forge->dropTable('PESSOAS');
    }
}
