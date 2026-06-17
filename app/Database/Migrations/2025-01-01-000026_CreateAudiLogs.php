<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAudiLogs extends Migration
{
    protected $DBGroup = 'loggerDB';

    public function up()
    {
        $this->forge->addField([
            'ID_LOG' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial do log (PK)',
            ],
            'NIVEL' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'Nível do log: DEBUG, INFO, WARNING, ERROR, CRITICAL',
            ],
            'MENSAGEM' => [
                'type'    => 'TEXT',
                'comment' => 'Mensagem descritiva do evento',
            ],
            'CONTEXTO' => [
                'type'    => 'JSON',
                'null'    => true,
                'comment' => 'Dados contextuais adicionais em formato JSON',
            ],
            'TABELA' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Nome da tabela associada ao evento (referência lógica)',
            ],
            'TABELA_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do registro associado ao evento',
            ],
            'USUARIO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário relacionado ao evento (referência lógica)',
            ],
            'ENDERECO_IP' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
                'comment'    => 'Endereço IP de origem da requisição',
            ],
            'URL_ORIGEM' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'comment'    => 'URL de origem da requisição',
            ],
            'CRIADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora exata em que o log foi gerado',
            ],
        ]);

        $this->forge->addKey('ID_LOG', true);
        $this->forge->addKey('NIVEL');
        $this->forge->addKey('USUARIO_ID');
        $this->forge->addKey('CRIADO_EM');
        $this->forge->createTable('AUDI_LOGS');
    }

    public function down()
    {
        $this->forge->dropTable('AUDI_LOGS');
    }
}
