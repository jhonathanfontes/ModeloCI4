# SIST_PLANO_MODULOS

## Objetivo
Tabela pivô que associa planos (`SIST_PLANOS`) aos módulos do menu (`MENU_MODULOS`).
Determina quais módulos estão disponíveis para cada plano de assinatura.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PLANO_MODULO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do vínculo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| PLANO_ID | BIGINT UNSIGNED | NOT NULL | FK → SIST_PLANOS(ID_PLANO) |
| MODULO_ID | BIGINT UNSIGNED | NOT NULL | FK → MENU_MODULOS(ID_MODULO) |
| SITUACAO_ID | BIGINT UNSIGNED | NOT NULL | FK → SIST_SITUACOES(ID_SITUACAO) |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Soft Delete |
| CRIADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |

## Mapeamento de Restrições

| Tipo | Coluna(s) | Referência |
|---|---|---|
| PRIMARY KEY | ID_PLANO_MODULO | — |
| UNIQUE | UUID | — |
| UNIQUE | (PLANO_ID, MODULO_ID) | — |
| FOREIGN KEY | PLANO_ID | SIST_PLANOS(ID_PLANO) |
| FOREIGN KEY | MODULO_ID | MENU_MODULOS(ID_MODULO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |

## Regras de Negócio

- Um par (PLANO_ID, MODULO_ID) deve ser único; não é permitido vincular o mesmo módulo duas vezes ao mesmo plano.
- Nenhuma operação CASCADE; a desativação de um vínculo é feita via SITUACAO_ID.

## Payload de Exemplo

```json
{
  "ID_PLANO_MODULO": 1,
  "UUID": "a1b2c3d4-e5f6-7890-abcd-123456789012",
  "PLANO_ID": 1,
  "MODULO_ID": 3,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-06-01 10:00:00"
}
```
