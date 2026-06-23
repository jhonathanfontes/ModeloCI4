<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuServicos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_SERVICO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do serviço (PK)',
            ],
            'UUID' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'comment' => 'Identificador único público universal (UUID4)',
            ],
            'MODULO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira para MENU_MODULOS',
            ],
            'NOME' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'Nome do serviço para exibição',
            ],
            'DESCRICAO' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Descrição detalhada do serviço',
            ],
            'URL_MODULO' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Rota do módulo',
            ],
            'URL_ROTA' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Rota padrão do serviço',
            ],
            'ICONE' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Classe do ícone (FontAwesome / Material)',
            ],
            'ORDEM' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'Ordem de exibição dentro do módulo',
            ],
            'DASHBOARD' => [
                'type' => 'BOOLEAN',
                'null' => true,
                'comment' => 'Indica se o serviço deve ser exibido no dashboard',
            ],
            'SITUACAO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Chave estrangeira para SIST_SITUACOES',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora da última modificação',
            ],
            'EXCLUIDO_EM' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data de exclusão lógica (Soft Delete)',
            ],
            'CRIADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário que criou o registro',
            ],
            'ATUALIZADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do último usuário que alterou o registro',
            ],
            'EXCLUIDO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário que executou a exclusão lógica',
            ],
        ]);

        $this->forge->addKey('ID_SERVICO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('MODULO_ID', 'MENU_MODULOS', 'ID_MODULO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('MENU_SERVICOS');
    }

    public function down()
    {
        $this->forge->dropTable('MENU_SERVICOS');
    }
}
