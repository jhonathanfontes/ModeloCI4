# PESSOAS

## Objetivo
Tabela central de CPF/CNPJ para vincular registros de clientes (CLIENTES)
que compartilham o mesmo documento. Garante a unicidade do CPF/CNPJ em todo
o sistema e permite que uma mesma pessoa física ou jurídica seja associada a
múltiplos clientes (ex: filiais, representações).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PESSOA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da pessoa (PK) |
| CPF_CNPJ | VARCHAR(14) | NOT NULL | CPF (11 dígitos) ou CNPJ (14 dígitos), apenas números (UNIQUE) |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_PESSOA | — |
| UNIQUE | CPF_CNPJ | — |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CPF_CNPJ` armazenado apenas números. 11 dígitos para CPF, 14 para CNPJ.
- `CPF_CNPJ` é UNIQUE — garante a unicidade do documento em todo o sistema.
- CLIENTES apontam para PESSOAS via `PESSOA_ID`. Múltiplos clientes podem referenciar a mesma pessoa.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_PESSOA": 1,
  "CPF_CNPJ": "12345678901",
  "CRIADO_EM": "2025-01-01 00:00:00",
  "ATUALIZADO_EM": "2025-01-01 00:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": null,
  "ATUALIZADO_POR": null,
  "EXCLUIDO_POR": null
}
```
