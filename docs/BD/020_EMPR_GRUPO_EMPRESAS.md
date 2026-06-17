# EMPR_GRUPO_EMPRESAS

## Objetivo
Tabela pivô do relacionamento muitos-para-muitos entre EMPR_GRUPOS e EMPRESAS.
Uma empresa pode pertencer a múltiplos grupos; um grupo pode conter múltiplas
empresas.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_GRUPO_EMPRESA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do vínculo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| GRUPO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPR_GRUPOS |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_GRUPO_EMPRESA | — |
| UNIQUE | UUID | — |
| UNIQUE | (GRUPO_ID, EMPRESA_ID) | — |
| FOREIGN KEY | GRUPO_ID | EMPR_GRUPOS(ID_GRUPO) |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- A combinação `(GRUPO_ID, EMPRESA_ID)` é única.
- Exclusão lógica remove o vínculo sem afetar grupo ou empresa.

## Payload de Exemplo

```json
{
  "ID_GRUPO_EMPRESA": 1,
  "UUID": "c9d0e1f2-a3b4-5678-cdef-789012345678",
  "GRUPO_ID": 1,
  "EMPRESA_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
