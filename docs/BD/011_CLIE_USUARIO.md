# CLIE_USUARIO

## Objetivo
Armazenar contas de acesso de clientes cadastrados via site (web/self-service).
Cada registro vincula-se a uma pessoa (PESSOAS) pelo CPF/CNPJ e,
quando identificado, ao cliente correspondente (CLIENTES). Permite que um
cliente já existente no sistema seja reconhecido automaticamente pelo CPF.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_CLIE_USUARIO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do usuário cliente (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| CLIENTE_ID | BIGINT UNSIGNED | NULL | Chave estrangeira para CLIENTES (vinculado após identificação por CPF) |
| PESSOA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para PESSOAS (CPF/CNPJ do cadastro) |
| NOME | VARCHAR(255) | NOT NULL | Nome completo do usuário cliente |
| EMAIL | VARCHAR(255) | NOT NULL | E-mail de login do usuário cliente (UNIQUE) |
| SENHA_HASH | VARCHAR(255) | NOT NULL | Hash da senha (BCRYPT) |
| TELEFONE | VARCHAR(15) | NULL | Telefone de contato com DDD, apenas números |
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
| PRIMARY KEY | ID_CLIE_USUARIO | — |
| UNIQUE | UUID | — |
| UNIQUE | EMAIL | — |
| FOREIGN KEY | CLIENTE_ID | CLIENTES(ID_CLIENTE) |
| FOREIGN KEY | PESSOA_ID | PESSOAS(ID_PESSOA) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `EMAIL` é único por usuário cliente (login).
- `SENHA_HASH` deve utilizar BCRYPT.
- `PESSOA_ID` vincula ao CPF/CNPJ. Ao cadastrar, o sistema consulta PESSOAS;
  se a pessoa já existir, recupera o `ID_PESSOA` e busca CLIENTES vinculados
  para preencher `CLIENTE_ID`.
- `CLIENTE_ID` é nulo até que o cliente seja identificado como já existente.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_CLIE_USUARIO": 1,
  "UUID": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
  "CLIENTE_ID": 1,
  "PESSOA_ID": 1,
  "NOME": "Maria Oliveira",
  "EMAIL": "maria@email.com",
  "SENHA_HASH": "$2y$10$...",
  "TELEFONE": "11988887777",
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00",
  "ATUALIZADO_EM": "2025-01-20 14:30:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": null,
  "ATUALIZADO_POR": null,
  "EXCLUIDO_POR": null
}
```
