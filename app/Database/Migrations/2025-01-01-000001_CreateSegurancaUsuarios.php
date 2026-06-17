<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSegurancaUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_USUARIO' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do usuário (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nome completo do usuário',
            ],
            'EMAIL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'E-mail de login do usuário (UNIQUE)',
            ],
            'SENHA_HASH' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Hash da senha armazenado com algoritmo BCRYPT',
            ],
            'TIPO' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'comment'    => 'Tipo de conta: SYSTEM, EMPRESA, CLIENTE',
            ],
            'ULTIMO_LOGIN' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data e hora do último login bem-sucedido',
            ],
            'ULTIMO_IP' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
                'comment'    => 'Endereço IP do último acesso',
            ],
            'EMAIL_VERIFICADO_EM' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data de verificação do e-mail',
            ],
            'TENTATIVAS_LOGIN' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'Contador de tentativas de login falhas consecutivas',
            ],
            'BLOQUEADO_ATE' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Bloqueio temporário por excesso de tentativas de login',
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

        $this->forge->addKey('ID_USUARIO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey('EMAIL');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('USUARIOS');
    }

    public function down()
    {
        $this->forge->dropTable('SEGU_USUARIOS');
    }
}
