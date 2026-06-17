# USUA_USUARIO_EMPRESAS

## Objetivo
Tabela pivô que associa usuários a empresas, definindo em quais empresas
cada usuário pode atuar e qual perfil de acesso possui em cada uma.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_USUARIO_EMPRESA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do vínculo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| USUARIO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SEGU_USUARIOS |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| PERFIL_ID | BIGINT UNSIGNED | NULL | Chave estrangeira para PERF_PERFIS (perfil de acesso nesta empresa) |
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
| PRIMARY KEY | ID_USUARIO_EMPRESA | — |
| UNIQUE | UUID | — |
| UNIQUE | (USUARIO_ID, EMPRESA_ID) | — |
| FOREIGN KEY | USUARIO_ID | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | PERFIL_ID | PERF_PERFIS(ID_PERFIL) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- A combinação `(USUARIO_ID, EMPRESA_ID)` é única.
- `PERFIL_ID` define o papel do usuário na empresa (pode ser nulo se o perfil for definido por outro mecanismo).
- Exclusão lógica revoga o acesso do usuário à empresa.

## Payload de Exemplo

```json
{
  "ID_USUARIO_EMPRESA": 1,
  "UUID": "f2a3b4c5-d6e7-8901-fabc-012345678901",
  "USUARIO_ID": 1,
  "EMPRESA_ID": 1,
  "PERFIL_ID": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
