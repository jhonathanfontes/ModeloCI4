# EMPR_GRUPOS

## Objetivo
Agrupamento de empresas para organização corporativa (ex: Matriz, Filial SP,
Filial RJ). Permite operações em lote sobre um grupo de empresas.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_GRUPO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do grupo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(100) | NOT NULL | Nome do grupo (ex: Matriz, Filial Sudeste) |
| DESCRICAO | TEXT | NULL | Descrição detalhada do grupo |
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
| PRIMARY KEY | ID_GRUPO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- Grupos com `EXCLUIDO_EM` preenchido não podem ter novas empresas vinculadas.

## Payload de Exemplo

```json
{
  "ID_GRUPO": 1,
  "UUID": "b8c9d0e1-f2a3-4567-bcde-678901234567",
  "NOME": "Filial Sudeste",
  "DESCRICAO": "Empresas da região Sudeste",
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
