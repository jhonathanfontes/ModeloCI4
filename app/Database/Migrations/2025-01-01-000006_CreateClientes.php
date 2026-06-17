<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_CLIENTE' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do cliente (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'EMPRESA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira vinculada à empresa responsável na tabela EMPRESAS',
            ],
            'PESSOA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'Chave estrangeira vinculada à pessoa na tabela PESSOAS (CPF/CNPJ compartilhado)',
            ],
            'NOME' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nome completo (pessoa física) ou razão social (pessoa jurídica)',
            ],
            'NOME_FANTASIA' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Nome fantasia do cliente (pessoa jurídica)',
            ],
            'TIPO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira vinculada à classificação do cliente na tabela SIST_TIPOS',
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

        $this->forge->addKey('ID_CLIENTE', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('PESSOA_ID', 'PESSOAS', 'ID_PESSOA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('CLIENTES');
    }

    public function down()
    {
        $this->forge->dropTable('CLIENTES');
    }
}
