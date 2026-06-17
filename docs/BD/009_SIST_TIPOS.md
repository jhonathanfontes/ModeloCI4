# SIST_TIPOS

## Objetivo
Tabela genérica de tipos/classificações parametrizáveis do sistema. Permite
categorizar registros de diversos módulos (ex: tipo de endereço, tipo de
cliente, tipo de contato) sem criar tabelas específicas para cada contexto.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_TIPO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do tipo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| MODULO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para MENU_MODULOS (contexto do tipo) |
| CODIGO | VARCHAR(50) | NOT NULL | Código textual do tipo (ex: RESIDENCIAL, COMERCIAL, PF, PJ) |
| DESCRICAO | VARCHAR(255) | NOT NULL | Descrição amigável do tipo |
| ORDEM | INT | NOT NULL | Ordem de exibição em listas/selects |
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
| PRIMARY KEY | ID_TIPO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | MODULO_ID | MENU_MODULOS(ID_MODULO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CODIGO` único por `MODULO_ID` (um tipo não se repete no mesmo módulo).
- `ORDEM` define a posição de exibição (menor = primeiro).
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_TIPO": 1,
  "UUID": "c2d3e4f5-a6b7-8901-cdef-123456789abc",
  "MODULO_ID": 1,
  "CODIGO": "MATRIZ",
  "DESCRICAO": "Matriz / Sede principal",
  "ORDEM": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-01 00:00:00",
  "ATUALIZADO_EM": "2025-01-01 00:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": null,
  "ATUALIZADO_POR": null,
  "EXCLUIDO_POR": null
}
```
