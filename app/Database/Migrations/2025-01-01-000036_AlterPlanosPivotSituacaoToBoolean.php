<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPlanosPivotSituacaoToBoolean extends Migration
{
    public function up()
    {
        // ---- SIST_PLANO_MODULOS ----
        $this->forge->dropForeignKey('SIST_PLANO_MODULOS', 'SIST_PLANO_MODULOS_SITUACAO_ID_foreign');
        $this->forge->dropKey('SIST_PLANO_MODULOS', 'SIST_PLANO_MODULOS_SITUACAO_ID_foreign');
        $this->db->query("ALTER TABLE SIST_PLANO_MODULOS CHANGE COLUMN SITUACAO_ID SITUACAO TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se o vínculo está ativo (1) ou inativo (0)'");

        // ---- SIST_PLANO_SERVICOS ----
        $this->forge->dropForeignKey('SIST_PLANO_SERVICOS', 'SIST_PLANO_SERVICOS_SITUACAO_ID_foreign');
        $this->forge->dropKey('SIST_PLANO_SERVICOS', 'SIST_PLANO_SERVICOS_SITUACAO_ID_foreign');
        $this->db->query("ALTER TABLE SIST_PLANO_SERVICOS CHANGE COLUMN SITUACAO_ID SITUACAO TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se o vínculo está ativo (1) ou inativo (0)'");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE SIST_PLANO_MODULOS CHANGE COLUMN SITUACAO SITUACAO_ID BIGINT UNSIGNED NOT NULL COMMENT 'Chave estrangeira para SIST_SITUACOES'");
        $this->db->query("ALTER TABLE SIST_PLANO_SERVICOS CHANGE COLUMN SITUACAO SITUACAO_ID BIGINT UNSIGNED NOT NULL COMMENT 'Chave estrangeira para SIST_SITUACOES'");

        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT', 'SIST_PLANO_MODULOS_SITUACAO_ID_foreign');
        $this->forge->addForeignKey('SITUACAO_ID', 'SIST_SITUACOES', 'ID_SITUACAO', 'RESTRICT', 'RESTRICT', 'SIST_PLANO_SERVICOS_SITUACAO_ID_foreign');
    }
}
