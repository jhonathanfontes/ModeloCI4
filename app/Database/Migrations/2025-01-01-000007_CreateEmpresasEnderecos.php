<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasEnderecos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_ENDERECO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do endereço (PK)',
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
            'TIPO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira vinculada ao tipo de endereço na tabela SIST_TIPOS',
            ],
            'CEP' => [
                'type' => 'VARCHAR',
                'constraint' => 8,
                'comment' => 'CEP do endereço, apenas números',
            ],
            'LOGRADOURO' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Logradouro do endereço',
            ],
            'NUMERO' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Número do endereço',
            ],
            'COMPLEMENTO' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Complemento do endereço',
            ],
            'BAIRRO' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'comment' => 'Bairro do endereço',
            ],
            'CIDADE' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'comment' => 'Cidade do endereço',
            ],
            'UF' => [
                'type' => 'CHAR',
                'constraint' => 2,
                'comment' => 'Sigla da unidade federativa em caixa alta',
            ],
            'PRINCIPAL' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Indica se é o endereço principal (1) ou secundário (0)',
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

        $this->forge->addKey('ID_ENDERECO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('TIPO_ID', 'SIST_TIPOS', 'ID_TIPO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPR_ENDERECOS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPR_ENDERECOS');
    }
}
