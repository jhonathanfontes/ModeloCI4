<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_EMPRESA' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial da empresa (PK)',
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'RAZAO_SOCIAL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Razão social jurídica e oficial da empresa',
            ],
            'NOME_FANTASIA' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nome fantasia / nome de divulgação da empresa',
            ],
            'CPF_CNPJ' => [
                'type'       => 'VARCHAR',
                'constraint' => 14,
                'comment'    => 'CNPJ ou CPF da empresa contendo apenas números (UNIQUE)',
            ],
            'EMAIL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'E-mail corporativo principal de contato',
            ],
            'TELEFONE' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'comment'    => 'Telefone fixo corporativo com DDD, apenas números',
            ],
            'CELULAR' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'comment'    => 'Celular corporativo com DDD, apenas números',
            ],
            'CEP' => [
                'type'       => 'VARCHAR',
                'constraint' => 8,
                'comment'    => 'CEP do endereço sede, apenas números',
            ],
            'LOGRADOURO' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Logradouro do endereço sede da empresa',
            ],
            'NUMERO' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'Número do endereço sede',
            ],
            'COMPLEMENTO' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Complemento do endereço sede',
            ],
            'BAIRRO' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'comment'    => 'Bairro do endereço sede',
            ],
            'CIDADE' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'comment'    => 'Cidade do endereço sede',
            ],
            'UF' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'comment'    => 'Sigla da unidade federativa em caixa alta',
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

        $this->forge->addKey('ID_EMPRESA', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addUniqueKey('CPF_CNPJ');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('EMPRESAS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPRESAS');
    }
}
