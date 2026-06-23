# EMPR_LICENCAS

## Objetivo
Registra a licença (plano) atribuída a cada empresa. Define qual plano a empresa possui e o período de vigência.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_LICENCA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | FK → EMPRESAS(ID_EMPRESA) |
| PLANO_ID | BIGINT UNSIGNED | NOT NULL | FK → SIST_PLANOS(ID_PLANO) |
| DATA_INICIO | DATE | NULL | Data de início da vigência |
| DATA_FIM | DATE | NULL | Data de término da vigência |
| SITUACAO_ID | BIGINT UNSIGNED | NOT NULL | FK → SIST_SITUACOES(ID_SITUACAO) |
| CRIADO_EM | DATETIME | NOT NULL | Data de inserção |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Soft Delete |
| CRIADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |

## Mapeamento de Restrições

| Tipo | Coluna(s) | Referência |
|---|---|---|
| PRIMARY KEY | ID_LICENCA | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | PLANO_ID | SIST_PLANOS(ID_PLANO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |

## Payload de Exemplo

```json
{
  "ID_LICENCA": 1,
  "UUID": "a1b2c3d4-e5f6-7890-abcd-123456789012",
  "EMPRESA_ID": 1,
  "PLANO_ID": 2,
  "DATA_INICIO": "2025-06-01",
  "DATA_FIM": null,
  "SITUACAO_ID": 1
}
```
