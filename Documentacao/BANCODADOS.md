Estrutura Geral do Banco de Dados (Versão Atual)

Sempre criar um arquico com a estrutura sugerida no docs/BD antes de criar o migrate. 
OS NOMES DA TABELA SEMPRE EM CAIXA ALTA.
OS CAMPOS DA TABELA SEMPRE EM CAIXA ALTA.
INCLUIR COMENTARIOS NOS CAMPOS QUE ESTA CRIANDO.

USAR O NOME DO DA TABELA PRINCIPAL: EX. EMPRESAS
USAR O PREFIXO NAS COMPLEMENTARIOS: EX. EMPR_CONFIGURACAO.

O BANCO DE DADOS DE LOGS E SEPARADO.

## Banco de Dados

- Nomes de tabelas e colunas em **UPPERCASE**
- PK: prefixo `ID_` (ex: `ID_EMPRESA`, `ID_USUARIO`)
- FK: sufixo `_ID` (ex: `EMPRESA_ID`, `USUARIO_ID`)
- Prefixos por domínio:

| Prefixo | Domínio |
|---------|---------|
| `EMPR_` / `EMPRESAS` | Empresas |
| `ORGA_` | Organizacional (departamentos/seções) |
| `USUA_` | Usuários |
| `PERF_` | Perfis/Permissões |
| `SIST_` | Sistema |
| `CLIE_` / `CLIENTES` | Clientes |
| `ARQV_` | Arquivos |
| `AUDI_` / `SEGU_` | Auditoria/Logs |

### Domínio MENU

| Tabela | Descrição | Colunas-chave |
|--------|-----------|---------------|
| `MENU_TIPO` | Tipo de Menu | ID_TIPO, DESCRICAO, ATIVO |
| `MENU_TIPOMODULO` | Tipo de Menu | ID_TIPOMODULO, TIPO_ID, MODULO_ID, DESCRICAO, ATIVO |
| `MENU_MODULOS` | Módulos do sistema | ID_MODULO, CODIGO, SLUG, NOME, ICONE, ORDEM, ATIVO |
| `MENU_SERVICOS` | Serviços do sistema | ID_SERVICO, UUID, MODULO_ID, NOME, SLUG, DESCRICAO, ROTA, ICONE, ORDEM, ATIVO |
| `MENU_FUNCIONALIDADES` | Funcionalidades dos serviços | ID_FUNCIONALIDADE, UUID, SERVICO_ID, NOME, SLUG, DESCRICAO, ATIVO |

#### Domínio SISTEMA

| Tabela | Descrição | Colunas-chave |
|--------|-----------|---------------|
| `SIST_SITUACOES` | Status centralizados (substitui ENUMs) | ID_SITUACAO, MODULO, CODIGO, DESCRICAO, COR, ICONE, FINALIZADORA, CONCLUIDA, CANCELADA, PENDENTE, BLOQUEIA_EDICAO, GERA_HISTORICO |
| `SIST_TRANSICOES` | Transições de workflow | ID_TRANSICAO, MODULO_ID, SITUACAO_ORIGEM_ID, SITUACAO_DESTINO_ID |
| `SIST_TIPOS` | Tipos genéricos | ID_TIPO, MODULO_ID, CODIGO, DESCRICAO, ORDEM, SITUACAO_ID |
| `SIST_PARAMETROS` | Parâmetros globais | ID_PARAMETRO, CHAVE (unique), VALOR, DESCRICAO |
| `SIST_PLANOS` | Planos de assinatura | ID_PLANO, UUID, NOME, SLUG, DESCRICAO, USUARIOS_LIMITE, ARMAZENAMENTO_LIMITE |
| `SIST_ACOES` | Ações padrão (CRUD + aprovar, exportar, imprimir) | ID_ACAO, UUID, NOME, SLUG, DESCRICAO, ATIVO |
| `SIST_SERVICO_ACOES` | Ações disponíveis por serviço | ID_SERVICO_ACAO, UUID, SERVICO_ID, ACAO_ID, OBRIGATORIA |
| `SIST_PLANO_MODULOS` | Módulos incluídos em cada plano | ID_PLANO_MODULO, UUID, PLANO_ID, MODULO_ID, ATIVO |
| `SIST_PLANO_SERVICOS` | Serviços incluídos em cada plano | ID_PLANO_SERVICO, UUID, PLANO_ID, SERVICO_ID, ATIVO |

#### Domínio EMPRESAS

| Tabela | Descrição | Colunas-chave |
|--------|-----------|---------------|
| `EMPRESAS` | Cadastro de empresas | ID_EMPRESA, UUID, RAZAO_SOCIAL, NOME_FANTASIA, CNPJ, SITUACAO_ID |
| `EMPR_CONFIGURACOES` | Configurações por empresa | ID_CONFIGURACAO, EMPRESA_ID, CHAVE, VALOR |
| `EMPR_GRUPOS` | Grupos empresariais | ID_GRUPO, NOME, DESCRICAO, SITUACAO_ID |
| `EMPR_GRUPO_EMPRESAS` | Vínculo grupo-empresa | ID_GRUPO_EMPRESA, GRUPO_ID, EMPRESA_ID |
| `EMPR_LICENCAS` | Licenças | ID_LICENCA, EMPRESA_ID, ... |
| `EMPR_MODULOS` | Módulos contratados | EMPRESA_ID, MODULO_ID |
| `EMPR_EMPRESA_SERVICOS` | Serviços habilitados por empresa | ID_EMPRESA_SERVICO, UUID, EMPRESA_ID, SERVICO_ID, ATIVO |

#### Domínio USUA (Usuários)

| Tabela | Descrição | Colunas-chave |
|--------|-----------|---------------|
| `SEGU_USUARIOS` | Contas de usuário | ID_USUARIO, UUID, NOME, EMAIL, SENHA_HASH, TIPO (SYSTEM/EMPRESA/CLIENTE), SITUACAO_ID |
| `USUA_USUARIO_EMPRESAS` | Vínculo usuário-empresa-perfil | ID_USUARIO_EMPRESA, UUID, USUARIO_ID, EMPRESA_ID, PERFIL_ID, EMPRESA_PADRAO, ATIVO |

#### Domínio CLIE (Clientes)

| Tabela | Descrição | Colunas-chave |
|--------|-----------|---------------|
| `CLIENTES` | Cadastro de clientes/pessoas | ID_CLIENTE, EMPRESA_ID, TIPO_ID, SITUACAO_ID, NOME, CPF_CNPJ |
| `CLIE_ENDERECOS` | Endereços de clientes | ID_ENDERECO, CLIENTE_ID, TIPO_ID, CEP, LOGRADOURO, PRINCIPAL |
| `CLIE_CONTATOS` | Contatos de clientes | ID_CONTATO, CLIENTE_ID, NOME, CARGO, TELEFONE, EMAIL |

#### Logger DB (logger_ci4 — conexão separada)

| Tabela | Descrição |
|--------|-----------|
| `AUDI_AUDITORIA` | Trilha de auditoria completa |
| `AUDI_LOGS` | Logs de auditoria |
| `SEGU_LOGS` | Logs de segurança |
