===============================================================================
               PADRÃO OFICIAL DE MODELAGEM DE BANCO DE DADOS
===============================================================================

-------------------------------------------------------------------------------
1. OBJETIVO
-------------------------------------------------------------------------------
Todo desenvolvimento que envolva banco de dados deverá seguir obrigatoriamente 
este padrão.

Antes da criação de qualquer Migration do CodeIgniter 4, deve ser criado um 
documento de modelagem na pasta: docs/BD/

O documento servirá como fonte oficial da estrutura da tabela, regras de 
negócio, relacionamentos, índices e comentários dos campos.

Somente após aprovação da documentação por um Tech Lead/DBA a Migration poderá 
ser criada e executada.


-------------------------------------------------------------------------------
2. REGRAS GERAIS DE NOMENCLATURA
-------------------------------------------------------------------------------
2.1. Tabelas
- Sempre em CAIXA ALTA (SNAKE_CASE).
- No plural para entidades principais (ex: EMPRESAS, CLIENTES).
- Tabelas de relacionamento/pivô devem combinar os nomes das tabelas 
  relacionadas (ex: EMPR_GRUPO_EMPRESAS).
- Sem caracteres especiais, espaços ou acentuação.

Exemplos: EMPRESAS, CLIENTES, MENU_MODULOS, SIST_SITUACOES, SEGU_USUARIOS

2.2. Colunas
- Sempre em CAIXA ALTA (SNAKE_CASE).
- Devem ser autoexplicativas, evitando abreviações ambíguas (use RAZAO_SOCIAL 
  em vez de RZ_SOC).

Exemplos: RAZAO_SOCIAL, NOME_FANTASIA, DATA_NASCIMENTO, CRIADO_EM, ATUALIZADO_EM

2.3. Chaves Primárias (PK)
Sempre utilizar o prefixo ID_ seguido do nome da entidade no singular. Devem ser 
obrigatoriamente do tipo BIGINT, não nulas, sem sinal (unsigned) e com 
incremento automático.
Padrão: ID_NOME_DA_ENTIDADE

Exemplos:
- ID_EMPRESA      BIGINT UNSIGNED AUTO_INCREMENT
- ID_CLIENTE      BIGINT UNSIGNED AUTO_INCREMENT
- ID_MODULO       BIGINT UNSIGNED AUTO_INCREMENT
- ID_USUARIO      BIGINT UNSIGNED AUTO_INCREMENT

2.4. Chaves Estrangeiras (FK)
Sempre utilizar o nome da entidade relacionada no singular seguido do sufixo _ID. 
A tipagem deve ser estritamente idêntica à PK de origem (BIGINT UNSIGNED).
Padrão: NOME_DA_ENTIDADE_ID

Exemplos:
- EMPRESA_ID      BIGINT UNSIGNED
- CLIENTE_ID      BIGINT UNSIGNED
- MODULO_ID       BIGINT UNSIGNED
- USUARIO_ID      BIGINT UNSIGNED

2.5. UUID (Universally Unique Identifier)
Toda entidade principal (tabelas base que sofrem exposição em APIs ou URLs) 
deve possuir obrigatoriamente um campo UUID para indexação pública e segurança.
Padrão: UUID CHAR(36)


-------------------------------------------------------------------------------
3. PADRONIZAÇÃO DE TIPOS DE DADOS
-------------------------------------------------------------------------------
Para evitar divergências de tamanho de campos entre diferentes tabelas, adote:

Dado / Finalidade               | Tipo no Banco   | Tamanho / Constraint
-------------------------------------------------------------------------------
Chaves Primárias / Estrangeiras | BIGINT          | unsigned => true
UUID                            | CHAR            | 36
CNPJ                            | VARCHAR         | 14 (Apenas números)
CPF                             | VARCHAR         | 11 (Apenas números)
Inscrição Estadual / Municipal  | VARCHAR         | 30
E-mail                          | VARCHAR         | 255
Senhas / Hashes                 | VARCHAR         | 255 (Ex: BCRYPT)
Slugs / URLs / Rotas            | VARCHAR         | 100 ou 255 (Caixa baixa)
Telefones (Fixo / Celular)      | VARCHAR         | 15 (Com DDD, apenas números)
CEP                             | VARCHAR         | 8 (Apenas números)
Siglas de Estados (UF)          | CHAR            | 2 (Caixa alta)
Endereços (Logradouro/Bairro)   | VARCHAR         | 255


-------------------------------------------------------------------------------
4. PREFIXAÇÃO DAS TABELAS (DOMÍNIOS)
-------------------------------------------------------------------------------
As tabelas devem ser categorizadas por domínios através de prefixos de 4 letras 
seguidos de underline '_'. Entidades base não utilizam prefixo.

Prefixo        | Domínio                         | Exemplos de Tabelas
-------------------------------------------------------------------------------
(Sem prefixo)  | Empresas / Clientes Base        | EMPRESAS, CLIENTES
EMPR_          | Complementos de Empresas        | EMPR_CONFIGURACOES, EMPR_LICENCAS
CLIE_          | Complementos de Clientes        | CLIE_ENDERECOS, CLIE_CONTATOS
USUA_          | Relacionamentos de Usuários     | USUA_USUARIO_EMPRESAS
PERF_          | Perfis e Permissões             | PERF_PERFIS, PERF_PERMISSOES
SIST_          | Core do Sistema / Regras Gerais | SIST_SITUACOES, SIST_PLANOS
MENU_          | Menus e Navegação dinâmicos     | MENU_MODULOS, MENU_SERVICOS
ORGA_          | Organograma / RH                | ORGA_DEPARTAMENTOS, ORGA_SECOES
ARQV_          | Armazenamento de Arquivos       | ARQV_ARQUIVOS, ARQV_VINCULOS
AUDI_          | Auditoria e Logs de Alterações  | AUDI_HISTORICOS, AUDI_LOGS
SEGU_          | Autenticação e Segurança        | SEGU_USUARIOS, SEGU_LOGS


-------------------------------------------------------------------------------
5. CAMPOS PADRÃO OBRIGATÓRIOS
-------------------------------------------------------------------------------
Todas as tabelas devem conter a estrutura abaixo mapeada ao final dos campos. 
Os campos _POR apontam para SEGU_USUARIOS(ID_USUARIO).

CRIADO_EM DATETIME
ATUALIZADO_EM DATETIME
EXCLUIDO_EM DATETIME NULL

CRIADO_POR BIGINT UNSIGNED NULL
ATUALIZADO_POR BIGINT UNSIGNED NULL
EXCLUIDO_POR BIGINT UNSIGNED NULL

Objetivos: Soft Delete (Nativo do CI4) e Auditoria Basal (Rastreabilidade).


-------------------------------------------------------------------------------
6. REGRAS DE INTEGRIDADE REFERENCIAL (FKs)
-------------------------------------------------------------------------------
- É proibido o uso de ON DELETE CASCADE em tabelas operacionais ou de domínio 
  financeiro/cadastral. Use ON DELETE RESTRICT.
- Como o sistema utiliza exclusão lógica (Soft Delete), chaves estrangeiras 
  nativas devem permitir valores NULL ou usar RESTRICT para evitar quebra de 
  histórico relacional.
- Toda coluna que atua como Chave Estrangeira deve possuir obrigatoriamente um 
  índice (INDEX) associado para otimização de JOINs.


-------------------------------------------------------------------------------
7. SISTEMA DE SITUAÇÕES
-------------------------------------------------------------------------------
É proibido o uso do tipo ENUM nativo do banco de dados. Toda e qualquer 
situação deve ser parametrizada dinamicamente mapeando a chave estrangeira 
SITUACAO_ID apontando para SIST_SITUACOES(ID_SITUACAO).

Exemplos de estados: ATIVO, INATIVO, PENDENTE, CANCELADO, BLOQUEADO, CONCLUIDO.


-------------------------------------------------------------------------------
8. DICIONÁRIO E ESTRUTURA DE TABELAS
-------------------------------------------------------------------------------

=== ESTRUTURA DE MENUS ===

MENU_TIPO
  ID_TIPO             BIGINT UNSIGNED AUTO_INCREMENT PK
  DESCRICAO           VARCHAR(100)
  ATIVO               TINYINT(1) DEFAULT 1

MENU_TIPOMODULO
  ID_TIPOMODULO       BIGINT UNSIGNED AUTO_INCREMENT PK
  TIPO_ID             BIGINT UNSIGNED FK
  MODULO_ID           BIGINT UNSIGNED FK
  DESCRICAO           VARCHAR(100)
  ATIVO               TINYINT(1) DEFAULT 1

MENU_MODULOS
  ID_MODULO           BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  CODIGO              VARCHAR(50) UNIQUE
  SLUG                VARCHAR(100) UNIQUE
  NOME                VARCHAR(100)
  DESCRICAO           VARCHAR(255)
  ICONE               VARCHAR(50)
  COR                 VARCHAR(20)
  ORDEM               INT DEFAULT 0
  SITUACAO_ID         BIGINT UNSIGNED FK

MENU_SERVICOS
  ID_SERVICO          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  MODULO_ID           BIGINT UNSIGNED FK
  NOME                VARCHAR(100)
  SLUG                VARCHAR(100) UNIQUE
  DESCRICAO           VARCHAR(255)
  ROTA                VARCHAR(255)
  COMPONENTE          VARCHAR(100)
  POLICY              VARCHAR(100)
  ICONE               VARCHAR(50)
  ORDEM               INT DEFAULT 0
  SITUACAO_ID         BIGINT UNSIGNED FK

MENU_FUNCIONALIDADES
  ID_FUNCIONALIDADE   BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  SERVICO_ID          BIGINT UNSIGNED FK
  NOME                VARCHAR(100)
  SLUG                VARCHAR(100) UNIQUE
  DESCRICAO           VARCHAR(255)
  ROTA                VARCHAR(255)
  COMPONENTE          VARCHAR(100)
  SITUACAO_ID         BIGINT UNSIGNED FK


=== DOMÍNIO SISTEMA ===

SIST_SITUACOES
  ID_SITUACAO         BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  MODULO              VARCHAR(100)
  CODIGO              VARCHAR(50)
  DESCRICAO           VARCHAR(255)
  COR                 VARCHAR(20)
  ICONE               VARCHAR(50)
  FINALIZADORA        TINYINT(1) DEFAULT 0
  CONCLUIDA           TINYINT(1) DEFAULT 0
  CANCELADA           TINYINT(1) DEFAULT 0
  PENDENTE            TINYINT(1) DEFAULT 1
  BLOQUEIA_EDICAO     TINYINT(1) DEFAULT 0
  GERA_HISTORICO      TINYINT(1) DEFAULT 1

SIST_TRANSICOES
  ID_TRANSICAO        BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  MODULO_ID           BIGINT UNSIGNED FK
  SITUACAO_ORIGEM_ID  BIGINT UNSIGNED FK
  SITUACAO_DESTINO_ID BIGINT UNSIGNED FK

SIST_TIPOS
  ID_TIPO             BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  MODULO_ID           BIGINT UNSIGNED FK
  CODIGO              VARCHAR(50)
  DESCRICAO           VARCHAR(255)
  ORDEM               INT DEFAULT 0
  SITUACAO_ID         BIGINT UNSIGNED FK

SIST_PARAMETROS
  ID_PARAMETRO        BIGINT UNSIGNED AUTO_INCREMENT PK
  CHAVE               VARCHAR(100) UNIQUE
  VALOR               TEXT
  DESCRICAO           VARCHAR(255)

SIST_PLANOS
  ID_PLANO            BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  NOME                VARCHAR(100)
  SLUG                VARCHAR(100) UNIQUE
  DESCRICAO           TEXT
  VALOR_MENSAL        DECIMAL(10,2) DEFAULT 0.00
  VALOR_ANUAL         DECIMAL(10,2) DEFAULT 0.00
  USUARIOS_LIMITE     INT DEFAULT 0
  ARMAZENAMENTO_LIMITE BIGINT DEFAULT 0
  SITUACAO_ID         BIGINT UNSIGNED FK

SIST_ACOES
  ID_ACAO             BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  CODIGO              VARCHAR(50) UNIQUE
  NOME                VARCHAR(100)
  SLUG                VARCHAR(100) UNIQUE
  DESCRICAO           VARCHAR(255)
  SITUACAO_ID         BIGINT UNSIGNED FK

SIST_SERVICO_ACOES
  ID_SERVICO_ACAO     BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  SERVICO_ID          BIGINT UNSIGNED FK
  ACAO_ID             BIGINT UNSIGNED FK
  OBRIGATORIA         TINYINT(1) DEFAULT 0

SIST_PLANO_MODULOS
  ID_PLANO_MODULO     BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  PLANO_ID            BIGINT UNSIGNED FK
  MODULO_ID           BIGINT UNSIGNED FK
  ATIVO               TINYINT(1) DEFAULT 1

SIST_PLANO_SERVICOS
  ID_PLANO_SERVICO    BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  PLANO_ID            BIGINT UNSIGNED FK
  SERVICO_ID          BIGINT UNSIGNED FK
  ATIVO               TINYINT(1) DEFAULT 1


=== DOMÍNIO EMPRESAS ===

EMPRESAS
  ID_EMPRESA          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  RAZAO_SOCIAL        VARCHAR(255)
  NOME_FANTASIA       VARCHAR(255)
  CNPJ                VARCHAR(14) UNIQUE
  EMAIL               VARCHAR(255)
  TELEFONE            VARCHAR(15)
  CELULAR             VARCHAR(15)
  CEP                 VARCHAR(8)
  LOGRADOURO          VARCHAR(255)
  NUMERO              VARCHAR(20)
  COMPLEMENTO         VARCHAR(100)
  BAIRRO              VARCHAR(120)
  CIDADE              VARCHAR(120)
  UF                  CHAR(2)
  SITUACAO_ID         BIGINT UNSIGNED FK

EMPR_CONFIGURACOES
  ID_CONFIGURACAO     BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  CHAVE               VARCHAR(100)
  VALOR               TEXT
  TIPO_DADO           VARCHAR(20)

EMPR_GRUPOS
  ID_GRUPO            BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  NOME                VARCHAR(100)
  DESCRICAO           VARCHAR(255)
  SITUACAO_ID         BIGINT UNSIGNED FK

EMPR_GRUPO_EMPRESAS
  ID_GRUPO_EMPRESA    BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  GRUPO_ID            BIGINT UNSIGNED FK
  EMPRESA_ID          BIGINT UNSIGNED FK

EMPR_LICENCAS
  ID_LICENCA          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  PLANO_ID            BIGINT UNSIGNED FK
  DATA_INICIO         DATE
  DATA_FIM            DATE
  SITUACAO_ID         BIGINT UNSIGNED FK

EMPR_MODULOS
  ID_EMPRESA_MODULO   BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  MODULO_ID           BIGINT UNSIGNED FK
  DATA_INICIO         DATE
  DATA_FIM            DATE
  ATIVO               TINYINT(1) DEFAULT 1

EMPR_EMPRESA_SERVICOS
  ID_EMPRESA_SERVICO  BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  SERVICO_ID          BIGINT UNSIGNED FK
  ATIVO               TINYINT(1) DEFAULT 1


=== DOMÍNIO USUÁRIOS E SEGURANÇA ===

SEGU_USUARIOS
  ID_USUARIO          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  NOME                VARCHAR(255)
  EMAIL               VARCHAR(255) UNIQUE
  SENHA_HASH          VARCHAR(255)
  TIPO                VARCHAR(30)
  ULTIMO_LOGIN        DATETIME NULL
  ULTIMO_IP           VARCHAR(45) NULL
  EMAIL_VERIFICADO_EM DATETIME NULL
  TENTATIVAS_LOGIN    INT DEFAULT 0
  BLOQUEADO_ATE       DATETIME NULL
  SITUACAO_ID         BIGINT UNSIGNED FK

USUA_USUARIO_EMPRESAS
  ID_USUARIO_EMPRESA  BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  USUARIO_ID          BIGINT UNSIGNED FK
  EMPRESA_ID          BIGINT UNSIGNED FK
  PERFIL_ID           BIGINT UNSIGNED FK
  EMPRESA_PADRAO      TINYINT(1) DEFAULT 0
  DATA_INICIO         DATE
  DATA_FIM            DATE NULL
  ATIVO               TINYINT(1) DEFAULT 1


=== DOMÍNIO PERFIS E PERMISSÕES ===

PERF_PERFIS
  ID_PERFIL           BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  NOME                VARCHAR(100)
  DESCRICAO           VARCHAR(255)
  SITUACAO_ID         BIGINT UNSIGNED FK

PERF_PERMISSOES
  ID_PERMISSAO        BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  PERFIL_ID           BIGINT UNSIGNED FK
  SERVICO_ID          BIGINT UNSIGNED FK
  ACAO_ID             BIGINT UNSIGNED FK
  PERMITIDO           TINYINT(1) DEFAULT 1

PERF_USUARIO_PERMISSOES
  ID_USUARIO_PERMISSAO BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                 CHAR(36) UNIQUE
  USUARIO_ID           BIGINT UNSIGNED FK
  SERVICO_ID           BIGINT UNSIGNED FK
  ACAO_ID              BIGINT UNSIGNED FK
  PERMITIDO            TINYINT(1) DEFAULT 1


=== DOMÍNIO CLIENTES ===

CLIENTES
  ID_CLIENTE          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  TIPO_ID             BIGINT UNSIGNED FK
  SITUACAO_ID         BIGINT UNSIGNED FK
  NOME                VARCHAR(255)
  NOME_FANTASIA       VARCHAR(255) NULL
  CPF_CNPJ            VARCHAR(14) UNIQUE
  DATA_NASCIMENTO     DATE NULL

CLIE_ENDERECOS
  ID_ENDERECO         BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  CLIENTE_ID          BIGINT UNSIGNED FK
  TIPO_ID             BIGINT UNSIGNED FK
  CEP                 VARCHAR(8)
  LOGRADOURO          VARCHAR(255)
  NUMERO              VARCHAR(20)
  COMPLEMENTO         VARCHAR(100) NULL
  BAIRRO              VARCHAR(120)
  CIDADE              VARCHAR(120)
  UF                  CHAR(2)
  PRINCIPAL           TINYINT(1) DEFAULT 0

CLIE_CONTATOS
  ID_CONTATO          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  CLIENTE_ID          BIGINT UNSIGNED FK
  NOME                VARCHAR(150)
  CARGO               VARCHAR(100) NULL
  TELEFONE            VARCHAR(15) NULL
  EMAIL               VARCHAR(255) NULL
  WHATSAPP            VARCHAR(15) NULL
  PRINCIPAL           TINYINT(1) DEFAULT 0


=== DOMÍNIO ORGANIZACIONAL ===

ORGA_DEPARTAMENTOS
  ID_DEPARTAMENTO     BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  NOME                VARCHAR(100)
  SIGLA               VARCHAR(20)
  SITUACAO_ID         BIGINT UNSIGNED FK

ORGA_SECOES
  ID_SECAO            BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  DEPARTAMENTO_ID     BIGINT UNSIGNED FK
  NOME                VARCHAR(100)
  SIGLA               VARCHAR(20)
  SITUACAO_ID         BIGINT UNSIGNED FK


=== DOMÍNIO ARQUIVOS ===

ARQV_ARQUIVOS
  ID_ARQUIVO          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  EMPRESA_ID          BIGINT UNSIGNED FK
  NOME_ORIGINAL       VARCHAR(255)
  NOME_ARMAZENADO     VARCHAR(255)
  CAMINHO             VARCHAR(500)
  EXTENSAO            VARCHAR(10)
  MIME_TYPE           VARCHAR(100)
  TAMANHO             BIGINT
  HASH                VARCHAR(64)

ARQV_VINCULOS
  ID_VINCULO          BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  ARQUIVO_ID          BIGINT UNSIGNED FK
  TABELA_ORIGEM       VARCHAR(100)
  REGISTRO_ID         BIGINT UNSIGNED


=== BANCO DE LOGS E AUDITORIA (CONEXÃO ISOLADA) ===
Base física separada: logger_ci4

AUDI_AUDITORIA -> Trilha transacional completa de requisições.
AUDI_LOGS      -> Logs genéricos de eventos de negócio e depuração.
SEGU_LOGS      -> Logs estritos de segurança e acessos falhos.

AUDI_HISTORICOS
  ID_HISTORICO        BIGINT UNSIGNED AUTO_INCREMENT PK
  UUID                CHAR(36) UNIQUE
  TABELA              VARCHAR(100)
  REGISTRO_ID         BIGINT UNSIGNED
  CAMPO               VARCHAR(100)
  VALOR_ANTIGO        TEXT NULL
  VALOR_NOVO          TEXT NULL
  DATA_EVENTO         DATETIME
  USUARIO_ID          BIGINT UNSIGNED


-------------------------------------------------------------------------------
9. REQUISITO OBRIGATÓRIO: COMENTÁRIOS E MIGRATIONS (GABARITO)
-------------------------------------------------------------------------------
Nenhum campo poderá ser enviado para aprovação sem a chave 'comment' preenchida. 
Segue o modelo estrutural exato a ser utilizado no CodeIgniter 4:

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_EMPRESA' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Identificador único sequencial da empresa (PK)'
            ],
            'UUID' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'comment'    => 'Identificador único público universal (UUID4)'
            ],
            'RAZAO_SOCIAL' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Razão social jurídica e oficial da empresa'
            ],
            'SITUACAO_ID' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'comment'  => 'Chave estrangeira vinculada à tabela SIST_SITUACOES'
            ],
            'CRIADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora exata de inserção do registro'
            ],
            'ATUALIZADO_EM' => [
                'type'    => 'DATETIME',
                'comment' => 'Data e hora da última modificação efetuada'
            ],
            'EXCLUIDO_EM' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data de exclusão lógica (Soft Delete)'
            ],
            'CRIADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário logador responsável pela criação'
            ],
            'ATUALIZADO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do último usuário responsável por atualizar'
            ],
            'EXCLUIDO_POR' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do usuário executor da exclusão lógica'
            ],
        ]);

        $this->forge->addKey('ID_EMPRESA', true);
        $this->forge->addUniqueKey('UUID');
        $this->forge->createTable('EMPRESAS');
    }

    public function down()
    {
        $this->forge->dropTable('EMPRESAS');
    }
}


-------------------------------------------------------------------------------
10. PROCESSO DE ENTRADA E DOCUMENTAÇÃO OBRIGATÓRIA
-------------------------------------------------------------------------------
Antes de submeter código, um arquivo Markdown descritivo da tabela deve ser 
commitado na pasta: docs/BD/

Exemplo de estrutura de arquivos:
docs/
└── BD/
    ├── 001_MENU_MODULOS.md
    ├── 002_MENU_SERVICOS.md
    ├── 003_SEGU_USUARIOS.md
    └── 004_EMPRESAS.md

O documento Markdown DEVE conter:
1. Objetivo da tabela.
2. Dicionário de dados (Campo, Tipo, Nulidade, Comentário).
3. Mapeamento de Restrições (PK, FK, UNIQUE).
4. Regras de Negócio aplicadas.
5. Payload de Exemplo em formato JSON.
