# CLIE_CONTATOS

## Objetivo
Armazenar contatos dos clientes. Permite múltiplos contatos por cliente.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_CONTATO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do contato (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| CLIENTE_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para CLIENTES |
| NOME | VARCHAR(150) | NOT NULL | Nome do contato |
| CARGO | VARCHAR(100) | NULL | Cargo do contato |
| TELEFONE | VARCHAR(15) | NULL | Telefone fixo (com DDD, apenas números) |
| EMAIL | VARCHAR(255) | NULL | E-mail de contato |
| WHATSAPP | VARCHAR(15) | NULL | Número de WhatsApp (com DDD, apenas números) |
| PRINCIPAL | TINYINT(1) | NOT NULL | Indica se é o contato principal do cliente |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_CONTATO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | CLIENTE_ID | CLIENTES(ID_CLIENTE) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `PRINCIPAL` = 1 indica contato principal. Deve haver no máximo 1 principal por cliente.
- Pelo menos um dos campos `TELEFONE`, `EMAIL` ou `WHATSAPP` deve ser preenchido.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_CONTATO": 1,
  "UUID": "a7b8c9d0-e1f2-3456-7890-abcdef123456",
  "CLIENTE_ID": 1,
  "NOME": "Ana Pereira",
  "CARGO": "Contato Financeiro",
  "TELEFONE": "2130003333",
  "EMAIL": "ana@cliente.com",
  "WHATSAPP": "21988885555",
  "PRINCIPAL": 1,
  "CRIADO_EM": "2025-01-15 10:00:00",
  "ATUALIZADO_EM": "2025-01-15 10:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
