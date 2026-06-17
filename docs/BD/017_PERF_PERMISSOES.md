# PERF_PERMISSOES

## Objetivo
Matriz de permissões que associa perfis a funcionalidades e ações,
definindo quais operações cada perfil pode executar.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PERMISSAO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da permissão (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| PERFIL_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para PERF_PERFIS |
| FUNCIONALIDADE_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para MENU_FUNCIONALIDADES |
| ACAO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_ACOES |
| PERMITIDO | TINYINT | NOT NULL | 1 = permitido, 0 = negado (negação explícita) |
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
| PRIMARY KEY | ID_PERMISSAO | — |
| UNIQUE | UUID | — |
| UNIQUE | (PERFIL_ID, FUNCIONALIDADE_ID, ACAO_ID) | — |
| FOREIGN KEY | PERFIL_ID | PERF_PERFIS(ID_PERFIL) |
| FOREIGN KEY | FUNCIONALIDADE_ID | MENU_FUNCIONALIDADES(ID_FUNCIONALIDADE) |
| FOREIGN KEY | ACAO_ID | SIST_ACOES(ID_ACAO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- A combinação `(PERFIL_ID, FUNCIONALIDADE_ID, ACAO_ID)` é única.
- `PERMITIDO = 0` permite negação explícita (herdar permissão de outro perfil e depois negar).
- Exclusão lógica desativa a permissão sem removê-la.

## Payload de Exemplo

```json
{
  "ID_PERMISSAO": 1,
  "UUID": "f6a7b8c9-d0e1-2345-fabc-456789012345",
  "PERFIL_ID": 1,
  "FUNCIONALIDADE_ID": 1,
  "ACAO_ID": 1,
  "PERMITIDO": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
