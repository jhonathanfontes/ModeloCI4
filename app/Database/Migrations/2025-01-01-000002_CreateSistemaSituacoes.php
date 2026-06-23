<?php

namespace App\Database\Migrations;

use App\Dominios\Dominio;
use CodeIgniter\Database\Migration;

class CreateSistemaSituacoes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_SITUACAO' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Identificador único sequencial da situação (PK)',
            ],
            'UUID' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'comment' => 'Identificador único público universal (UUID4) para uso em APIs e URLs',
            ],
            'MODULO' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'Agrupador do contexto da situação (ex: EMPRESAS, USUARIOS)',
            ],
            'CODIGO' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => 'Código textual da situação (ex: ATIVO, INATIVO, PENDENTE)',
            ],
            'DESCRICAO' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Descrição amigável da situação',
            ],
            'COR' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'comment' => 'Cor hexadecimal para representação visual (ex: #28a745)',
            ],
            'ICONE' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Ícone para representação visual',
            ],
            'FINALIZADO' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Indica se é uma situação finalizado (não permite transição)',
            ],
            'CONCLUIDA' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Indica se o registro foi concluído com sucesso',
            ],
            'CANCELADA' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Indica se o registro foi cancelado',
            ],
            'PENDENTE' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => 'Indica se o registro está pendente de ação',
            ],
            'BLOQUEIA_EDICAO' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Bloqueia edição do registro quando True',
            ],
            'GERA_HISTORICO' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => 'Gera entrada em AUDI_HISTORICOS ao transicionar para esta situação',
            ],
            'CRIADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora exata de inserção do registro',
            ],
            'ATUALIZADO_EM' => [
                'type' => 'DATETIME',
                'comment' => 'Data e hora da última modificação efetuada',
            ],
            'EXCLUIDO_EM' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Data de exclusão lógica (Soft Delete). Se nulo, o registro está ativo',
            ],
            'CRIADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário responsável pela criação do registro',
            ],
            'ATUALIZADO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do último usuário responsável por atualizar o registro',
            ],
            'EXCLUIDO_POR' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID do usuário executor da exclusão lógica do registro',
            ],
        ]);

        $this->forge->addKey('ID_SITUACAO', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->createTable('SIST_SITUACOES');

        $this->seed();
    }

    public function down()
    {
        $this->forge->dropTable('SIST_SITUACOES');
    }

    private function seed(): void
    {
        $agora = date('Y-m-d H:i:s');

        $registros = [];
        foreach (Dominio::classes() as $classe) {
            foreach ($classe::dadosBanco() as $dado) {
                $dado['CRIADO_EM'] = $agora;
                $dado['ATUALIZADO_EM'] = $agora;
                $registros[] = $dado;
            }
        }

        if ($registros !== []) {
            $this->db->table('SIST_SITUACOES')->insertBatch($registros);
        }
    }
}
