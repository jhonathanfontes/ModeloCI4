<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsuarioEmpresasUniqueKey extends Migration
{
    public function up()
    {
        $this->db->query('CREATE INDEX IDX_USUARIO_ID ON USUA_USUARIO_EMPRESAS(USUARIO_ID)');
        $this->db->query('CREATE INDEX IDX_EMPRESA_ID ON USUA_USUARIO_EMPRESAS(EMPRESA_ID)');
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS ADD UNIQUE KEY USUA_EMP_ATIVO_UK (USUARIO_ID, EMPRESA_ID) WHERE (EXCLUIDO_EM IS NULL)');
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS DROP INDEX USUARIO_ID_EMPRESA_ID');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS ADD UNIQUE KEY USUARIO_ID_EMPRESA_ID (USUARIO_ID, EMPRESA_ID)');
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS DROP INDEX USUA_EMP_ATIVO_UK');
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS DROP INDEX IDX_USUARIO_ID');
        $this->db->query('ALTER TABLE USUA_USUARIO_EMPRESAS DROP INDEX IDX_EMPRESA_ID');
    }
}
