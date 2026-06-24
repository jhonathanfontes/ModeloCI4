<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCadastroEntitiesTables extends Migration
{
    public function up()
    {
        // ── FORNECEDORES ────────────────────────────────────────────
        $this->forge->addField([
            'ID_FORNECEDOR' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Identificador único sequencial do fornecedor (PK)'],
            'UUID' => ['type' => 'CHAR', 'constraint' => 36, 'comment' => 'Identificador único público universal (UUID4)'],
            'EMPRESA_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para EMPRESAS'],
            'NOME' => ['type' => 'VARCHAR', 'constraint' => 255, 'comment' => 'Nome / Razão social do fornecedor'],
            'CPF_CNPJ' => ['type' => 'VARCHAR', 'constraint' => 14, 'null' => true, 'comment' => 'CPF (11 dígitos) ou CNPJ (14 dígitos) sem máscara'],
            'EMAIL' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'comment' => 'E-mail de contato do fornecedor'],
            'TELEFONE' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true, 'comment' => 'Telefone de contato (DDD+número, sem máscara)'],
            'CELULAR' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true, 'comment' => 'Celular de contato (DDD+número, sem máscara)'],
            'SITUACAO_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para SIST_SITUACOES'],
            'CRIADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora de inserção do registro'],
            'ATUALIZADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora da última modificação'],
            'EXCLUIDO_EM' => ['type' => 'DATETIME', 'null' => true, 'comment' => 'Data de exclusão lógica (Soft Delete)'],
            'CRIADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que criou o registro'],
            'ATUALIZADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do último usuário que alterou o registro'],
            'EXCLUIDO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que executou a exclusão lógica'],
        ]);
        $this->forge->addKey('ID_FORNECEDOR', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('FORNECEDORES');

        // ── FUNCIONARIOS ────────────────────────────────────────────
        $this->forge->addField([
            'ID_FUNCIONARIO' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Identificador único sequencial do funcionário (PK)'],
            'UUID' => ['type' => 'CHAR', 'constraint' => 36, 'comment' => 'Identificador único público universal (UUID4)'],
            'EMPRESA_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para EMPRESAS'],
            'NOME' => ['type' => 'VARCHAR', 'constraint' => 255, 'comment' => 'Nome completo do funcionário'],
            'EMAIL' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'comment' => 'E-mail corporativo do funcionário'],
            'CARGO' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'comment' => 'Cargo ou função do funcionário'],
            'DEPARTAMENTO_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'Chave estrangeira para ORGA_DEPARTAMENTOS'],
            'TELEFONE' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true, 'comment' => 'Telefone de contato (DDD+número, sem máscara)'],
            'SITUACAO_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para SIST_SITUACOES'],
            'CRIADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora de inserção do registro'],
            'ATUALIZADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora da última modificação'],
            'EXCLUIDO_EM' => ['type' => 'DATETIME', 'null' => true, 'comment' => 'Data de exclusão lógica (Soft Delete)'],
            'CRIADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que criou o registro'],
            'ATUALIZADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do último usuário que alterou o registro'],
            'EXCLUIDO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que executou a exclusão lógica'],
        ]);
        $this->forge->addKey('ID_FUNCIONARIO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('DEPARTAMENTO_ID', 'ORGA_DEPARTAMENTOS', 'ID_DEPARTAMENTO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('FUNCIONARIOS');

        // ── PRODUTOS ────────────────────────────────────────────────
        $this->forge->addField([
            'ID_PRODUTO' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Identificador único sequencial do produto (PK)'],
            'UUID' => ['type' => 'CHAR', 'constraint' => 36, 'comment' => 'Identificador único público universal (UUID4)'],
            'EMPRESA_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para EMPRESAS'],
            'NOME' => ['type' => 'VARCHAR', 'constraint' => 255, 'comment' => 'Nome do produto'],
            'DESCRICAO' => ['type' => 'TEXT', 'null' => true, 'comment' => 'Descrição detalhada do produto'],
            'PRECO_CUSTO' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00, 'comment' => 'Preço de custo do produto'],
            'PRECO_VENDA' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00, 'comment' => 'Preço de venda do produto'],
            'UNIDADE' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true, 'comment' => 'Unidade de medida (UN, KG, CX, LT, etc.)'],
            'CODIGO_BARRAS' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'comment' => 'Código de barras do produto (EAN-13)'],
            'CODIGO_INTERNO' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'comment' => 'Código interno / SKU do produto'],
            'ESTOQUE' => ['type' => 'DECIMAL', 'constraint' => '15,3', 'default' => 0.000, 'comment' => 'Quantidade em estoque'],
            'SITUACAO_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para SIST_SITUACOES'],
            'CRIADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora de inserção do registro'],
            'ATUALIZADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora da última modificação'],
            'EXCLUIDO_EM' => ['type' => 'DATETIME', 'null' => true, 'comment' => 'Data de exclusão lógica (Soft Delete)'],
            'CRIADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que criou o registro'],
            'ATUALIZADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do último usuário que alterou o registro'],
            'EXCLUIDO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que executou a exclusão lógica'],
        ]);
        $this->forge->addKey('ID_PRODUTO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('PRODUTOS');

        // ── SERVICOS (Cadastro de Serviços / Ofertas) ───────────────
        $this->forge->addField([
            'ID_SERVICO' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Identificador único sequencial do serviço (PK) — não confundir com MENU_SERVICOS'],
            'UUID' => ['type' => 'CHAR', 'constraint' => 36, 'comment' => 'Identificador único público universal (UUID4)'],
            'EMPRESA_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para EMPRESAS'],
            'NOME' => ['type' => 'VARCHAR', 'constraint' => 255, 'comment' => 'Nome do serviço'],
            'DESCRICAO' => ['type' => 'TEXT', 'null' => true, 'comment' => 'Descrição detalhada do serviço'],
            'PRECO' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00, 'comment' => 'Preço do serviço'],
            'DURACAO_MINUTOS' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'comment' => 'Duração estimada em minutos'],
            'SITUACAO_ID' => ['type' => 'BIGINT', 'unsigned' => true, 'comment' => 'Chave estrangeira para SIST_SITUACOES'],
            'CRIADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora de inserção do registro'],
            'ATUALIZADO_EM' => ['type' => 'DATETIME', 'comment' => 'Data e hora da última modificação'],
            'EXCLUIDO_EM' => ['type' => 'DATETIME', 'null' => true, 'comment' => 'Data de exclusão lógica (Soft Delete)'],
            'CRIADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que criou o registro'],
            'ATUALIZADO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do último usuário que alterou o registro'],
            'EXCLUIDO_POR' => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true, 'comment' => 'ID do usuário que executou a exclusão lógica'],
        ]);
        $this->forge->addKey('ID_SERVICO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('EMPRESA_ID', 'EMPRESAS', 'ID_EMPRESA', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('SERVICOS');
    }

    public function down()
    {
        $this->forge->dropTable('SERVICOS');
        $this->forge->dropTable('PRODUTOS');
        $this->forge->dropTable('FUNCIONARIOS');
        $this->forge->dropTable('FORNECEDORES');
    }
}
