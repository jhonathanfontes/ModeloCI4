# AUDI_HISTORICOS

## Objetivo
Histórico de alterações em nível de campo — rastreia mudanças individuais em colunas
específicas ao longo do tempo. Complementa a AUDI_AUDITORIA com granularidade fina
para exibição de histórico em formulários e relatórios.

Banco de dados: `logger_ci4` (conexão separada).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_HISTORICO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do histórico (PK) |
| TABELA | VARCHAR(100) | NOT NULL | Nome da tabela onde o campo foi alterado |
| TABELA_ID | BIGINT UNSIGNED | NOT NULL | ID do registro na tabela de origem |
| CAMPO | VARCHAR(100) | NOT NULL | Nome da coluna que foi alterada |
| VALOR_ANTERIOR | TEXT | NULL | Valor do campo antes da alteração |
| VALOR_NOVO | TEXT | NULL | Valor do campo após a alteração |
| USUARIO_ID | BIGINT UNSIGNED | NULL | ID do usuário que realizou a alteração (referência lógica) |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora exata da alteração |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_HISTORICO | — |
| INDEX | TABELA | — |
| INDEX | TABELA_ID | — |
| INDEX | CAMPO | — |
| INDEX | USUARIO_ID | — |
| INDEX | CRIADO_EM | — |

## Regras de Negócio

- Tabela append-only: registros nunca são alterados ou excluídos.
- Para cada campo alterado em uma operação, um registro separado é inserido.
- `VALOR_ANTERIOR` e `VALOR_NOVO` são armazenados como string (TEXT) independentemente do tipo original.

## Payload de Exemplo

```json
{
  "ID_HISTORICO": 1,
  "TABELA": "CLIENTES",
  "TABELA_ID": 42,
  "CAMPO": "EMAIL",
  "VALOR_ANTERIOR": "joao@email.com",
  "VALOR_NOVO": "joao.novo@email.com",
  "USUARIO_ID": 1,
  "CRIADO_EM": "2025-06-17 10:30:00"
}
```
