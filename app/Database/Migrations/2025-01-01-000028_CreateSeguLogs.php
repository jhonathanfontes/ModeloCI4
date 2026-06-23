<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeguLogs extends Migration
{
    protected $DBGroup = 'loggerDB';

    public function up()
    {
        $this->forge->addField([
            'ID_LOG' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do log de segurança (PK)',
            ],
            'TIPO_EVENTO' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => 'Tipo do evento: LOGIN, LOGOUT, LOGIN_FALHO, BLOQUEIO, PERMISSAO_ALTERADA',
            ],
            'USUARIO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário envolvido no evento (referência lógica)',
            ],
            'USERNAME' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Nome de usuário informado no momento do evento',
            ],
            'EMAIL' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'E-mail informado no momento do evento',
            ],
            'MENSAGEM' => [
                'type' => 'TEXT',
                'comment' => 'Descrição detalhada do evento de segurança',
            ],
            'ENDERECO_IP' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'comment' => 'Endereço IP de origem do evento',
            ],
            'USER_AGENT' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'User-Agent do cliente HTTP',
            ],
            'SUCESSO' => [
                'type' => 'TINYINT',
                'null' => true,
                'comment' => '1 = operação bem-sucedida, 0 = falha, NULL = não se aplica',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora exata do evento',
            ],
        ]);

        $this->forge->addKey('ID_LOG', true);
        $this->forge->addKey('TIPO_EVENTO');
        $this->forge->addKey('USUARIO_ID');
        $this->forge->addKey('SUCESSO');
        $this->forge->addKey('CRIADO_EM');
        $this->forge->createTable('SEGU_LOGS');
    }

    public function down()
    {
        $this->forge->dropTable('SEGU_LOGS');
    }
}
