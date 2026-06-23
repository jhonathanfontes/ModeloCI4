<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSistemaPlanosSituacaoToBoolean extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('SIST_PLANOS', 'SIST_PLANOS_SITUACAO_ID_foreign');
        $this->forge->dropKey('SIST_PLANOS', 'SIST_PLANOS_SITUACAO_ID_foreign');

        $this->db->query("ALTER TABLE SIST_PLANOS CHANGE COLUMN SITUACAO_ID SITUACAO TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se o plano está ativo (1) ou inativo (0)'");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE SIST_PLANOS CHANGE COLUMN SITUACAO SITUACAO_ID BIGINT UNSIGNED NOT NULL COMMENT 'Chave estrangeira para SIST_SITUACOES'");

        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT', 'SIST_PLANOS_SITUACAO_ID_foreign');
    }
}
