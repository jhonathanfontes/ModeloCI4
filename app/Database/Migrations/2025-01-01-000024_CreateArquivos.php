<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArquivos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_ARQUIVO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do arquivo (PK)',
            ],
            'UUID' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'comment' => 'Identificador único público universal (UUID4)',
            ],
            'NOME_ORIGINAL' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nome original do arquivo no momento do upload',
            ],
            'NOME_ARMAZENADO' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nome gerado para armazenamento no disco',
            ],
            'CAMINHO' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'comment' => 'Caminho relativo dentro do diretório de uploads',
            ],
            'TIPO_MIME' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'Tipo MIME do arquivo (ex: application/pdf)',
            ],
            'TAMANHO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'Tamanho do arquivo em bytes',
            ],
            'EXTENSAO' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'comment' => 'Extensão do arquivo (ex: pdf, png, jpg)',
            ],
            'TABELA' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Nome da tabela associada (referência polimórfica)',
            ],
            'TABELA_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do registro na tabela associada',
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

        $this->forge->addKey('ID_ARQUIVO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('CRIADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ATUALIZADO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('EXCLUIDO_POR', 'SEGU_USUARIOS', 'ID_USUARIO', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('ARQV_ARQUIVOS');
    }

    public function down()
    {
        $this->forge->dropTable('ARQV_ARQUIVOS');
    }
}
