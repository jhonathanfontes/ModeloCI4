# MENU_FUNCIONALIDADES

## Objetivo
Funcionalidades atômicas dentro de cada serviço, utilizadas para controle de
permissão (ex: em Clientes → Criar, Editar, Excluir, Visualizar).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_FUNCIONALIDADE | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da funcionalidade (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| SERVICO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para MENU_SERVICOS |
| NOME | VARCHAR(100) | NOT NULL | Nome amigável da funcionalidade |
| DESCRICAO | TEXT | NULL | Descrição detalhada da funcionalidade |
| CHAVE | VARCHAR(100) | NOT NULL | Identificador único textual no formato `servico.acao` (ex: `cliente.criar`) |
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
| PRIMARY KEY | ID_FUNCIONALIDADE | — |
| UNIQUE | UUID | — |
| UNIQUE | CHAVE | — |
| FOREIGN KEY | SERVICO_ID | MENU_SERVICOS(ID_SERVICO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CHAVE` é única e segue o padrão `servico.acao` (ex: `cliente.criar`, `cliente.excluir`).
- Funcionalidades com `EXCLUIDO_EM` preenchido são desconsideradas nas permissões.

## Payload de Exemplo

```json
{
  "ID_FUNCIONALIDADE": 1,
  "UUID": "c3d4e5f6-a7b8-9012-cdef-123456789012",
  "SERVICO_ID": 1,
  "NOME": "Criar Cliente",
  "DESCRICAO": "Permite criar novos registros de clientes",
  "CHAVE": "cliente.criar",
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
