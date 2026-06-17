# SIST_ACOES

## Objetivo
Catálogo de ações do sistema (Create, Read, Update, Delete, Export, Import,
Approve, etc.). Utilizado em conjunto com MENU_FUNCIONALIDADES para o
controle granular de permissões.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_ACAO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da ação (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(50) | NOT NULL | Nome amigável da ação (ex: Criar, Visualizar) |
| CHAVE | VARCHAR(50) | NOT NULL | Identificador textual único (ex: create, read, update, delete) |
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
| PRIMARY KEY | ID_ACAO | — |
| UNIQUE | UUID | — |
| UNIQUE | CHAVE | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CHAVE` única, em inglês no singular (ex: `create`, `read`, `update`, `delete`).
- São ações genéricas reutilizadas por todas as funcionalidades do sistema.

## Payload de Exemplo

```json
{
  "ID_ACAO": 1,
  "UUID": "d4e5f6a7-b8c9-0123-defa-234567890123",
  "NOME": "Criar",
  "CHAVE": "create",
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
