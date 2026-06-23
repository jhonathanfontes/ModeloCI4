<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAudiAuditoria extends Migration
{
    protected $DBGroup = 'loggerDB';

    public function up()
    {
        $this->forge->addField([
            'ID_AUDITORIA' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial do registro de auditoria (PK)',
            ],
            'TABELA' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'Nome da tabela onde a operação foi executada',
            ],
            'TABELA_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'comment' => 'ID do registro afetado na tabela de origem',
            ],
            'OPERACAO' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Tipo de operação: INSERT, UPDATE ou DELETE',
            ],
            'DADOS_ANTERIORES' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Estado completo do registro antes da alteração (JSON)',
            ],
            'DADOS_NOVOS' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Estado completo do registro após a alteração (JSON)',
            ],
            'USUARIO_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário que executou a operação (referência lógica, sem FK)',
            ],
            'ENDERECO_IP' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'comment' => 'Endereço IP de origem da requisição (IPv4 ou IPv6)',
            ],
            'USER_AGENT' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'User-Agent do navegador ou cliente HTTP',
            ],
            'URL_ORIGEM' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'URL de origem da requisição',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora exata em que a operação foi registrada',
            ],
        ]);

        $this->forge->addKey('ID_AUDITORIA', true);
        $this->forge->addKey('TABELA');
        $this->forge->addKey('TABELA_ID');
        $this->forge->addKey('USUARIO_ID');
        $this->forge->addKey('CRIADO_EM');
        $this->forge->createTable('AUDI_AUDITORIA');
    }

    public function down()
    {
        $this->forge->dropTable('AUDI_AUDITORIA');
    }
}
