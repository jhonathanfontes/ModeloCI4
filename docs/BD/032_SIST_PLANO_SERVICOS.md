# SIST_PLANO_SERVICOS

## Objetivo
Tabela pivô que associa planos (`SIST_PLANOS`) aos serviços do menu (`MENU_SERVICOS`).
Determina quais serviços estão disponíveis para cada plano de assinatura.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PLANO_SERVICO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do vínculo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| PLANO_ID | BIGINT UNSIGNED | NOT NULL | FK → SIST_PLANOS(ID_PLANO) |
| SERVICO_ID | BIGINT UNSIGNED | NOT NULL | FK → MENU_SERVICOS(ID_SERVICO) |
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
| PRIMARY KEY | ID_PLANO_SERVICO | — |
| UNIQUE | UUID | — |
| UNIQUE | (PLANO_ID, SERVICO_ID) | — |
| FOREIGN KEY | PLANO_ID | SIST_PLANOS(ID_PLANO) |
| FOREIGN KEY | SERVICO_ID | MENU_SERVICOS(ID_SERVICO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |

## Regras de Negócio

- Um par (PLANO_ID, SERVICO_ID) deve ser único; não é permitido vincular o mesmo serviço duas vezes ao mesmo plano.
- Nenhuma operação CASCADE; a desativação de um vínculo é feita via SITUACAO_ID.

## Payload de Exemplo

```json
{
  "ID_PLANO_SERVICO": 1,
  "UUID": "b2c3d4e5-f6a7-8901-bcde-234567890123",
  "PLANO_ID": 1,
  "SERVICO_ID": 5,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-06-01 10:00:00"
}
```
