# SEGU_ACCOUNTS

## Objetivo
Contas de autenticação dos usuários do sistema. Separa os dados de login
(username/email, senha, bloqueio) dos dados cadastrais da pessoa
(SEGU_USUARIOS). Permite múltiplos métodos de autenticação.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_ACCOUNT | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da conta (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| USUARIO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SEGU_USUARIOS |
| USERNAME | VARCHAR(100) | NULL | Nome de usuário para login (UNIQUE, pode ser nulo se usar apenas e-mail) |
| EMAIL | VARCHAR(255) | NOT NULL | E-mail de login (UNIQUE) |
| SENHA_HASH | VARCHAR(255) | NOT NULL | Hash da senha com BCrypt |
| ULTIMO_LOGIN | DATETIME | NULL | Data e hora do último login bem-sucedido |
| TENTATIVAS_FALHAS | TINYINT UNSIGNED | NOT NULL | Contagem de tentativas de login consecutivas sem sucesso |
| BLOQUEADO_EM | DATETIME | NULL | Data em que a conta foi bloqueada por segurança |
| SITUACAO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_SITUACOES |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_ACCOUNT | — |
| UNIQUE | UUID | — |
| UNIQUE | USERNAME | — |
| UNIQUE | EMAIL | — |
| FOREIGN KEY | USUARIO_ID | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `USUARIO_ID` vincula a conta ao cadastro da pessoa no sistema.
- `USERNAME` é único, mas pode ser nulo (login exclusivamente por e-mail).
- `EMAIL` é único e obrigatório.
- Após `TENTATIVAS_FALHAS >= 5`, a conta é bloqueada automaticamente.
- Exclusão lógica desativa a conta sem perder histórico de autenticação.

## Payload de Exemplo

```json
{
  "ID_ACCOUNT": 1,
  "UUID": "e1f2a3b4-c5d6-7890-efab-901234567890",
  "USUARIO_ID": 1,
  "USERNAME": "joao.silva",
  "EMAIL": "joao@email.com",
  "SENHA_HASH": "$2y$10$...",
  "ULTIMO_LOGIN": "2025-06-17 08:15:00",
  "TENTATIVAS_FALHAS": 0,
  "BLOQUEADO_EM": null,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
