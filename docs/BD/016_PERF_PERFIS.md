# PERF_PERFIS

## Objetivo
Perfis de acesso (papéis/funções) atribuídos a usuários. Definem o conjunto
de permissões que um usuário possui no sistema.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PERFIL | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do perfil (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(100) | NOT NULL | Nome do perfil (ex: Administrador, Gerente, Usuário) |
| DESCRICAO | TEXT | NULL | Descrição detalhada do perfil |
| NIVEL | INT | NULL | Nível hierárquico (maior valor = mais privilégios) |
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
| PRIMARY KEY | ID_PERFIL | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- Perfis com `EXCLUIDO_EM` preenchido não podem ser atribuídos a usuários.
- `NIVEL` permite controle hierárquico (ex: um perfil nível 10 não pode gerenciar outro de nível 20).

## Payload de Exemplo

```json
{
  "ID_PERFIL": 1,
  "UUID": "e5f6a7b8-c9d0-1234-efab-345678901234",
  "NOME": "Administrador",
  "DESCRICAO": "Acesso total ao sistema",
  "NIVEL": 100,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
