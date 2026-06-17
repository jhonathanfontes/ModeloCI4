# EMPR_CONTATOS

## Objetivo
Armazenar contatos das empresas (telefones, e-mails de departamentos, etc.).
Permite múltiplos contatos por empresa.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_CONTATO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do contato (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| NOME | VARCHAR(150) | NOT NULL | Nome do contato ou descrição (ex: SAC, Financeiro) |
| CARGO | VARCHAR(100) | NULL | Cargo do contato na empresa |
| TELEFONE | VARCHAR(15) | NULL | Telefone fixo (com DDD, apenas números) |
| EMAIL | VARCHAR(255) | NULL | E-mail de contato |
| WHATSAPP | VARCHAR(15) | NULL | Número de WhatsApp (com DDD, apenas números) |
| PRINCIPAL | TINYINT(1) | NOT NULL | Indica se é o contato principal da empresa |
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
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `PRINCIPAL` = 1 indica contato principal. Deve haver no máximo 1 principal por empresa.
- Pelo menos um dos campos `TELEFONE`, `EMAIL` ou `WHATSAPP` deve ser preenchido.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_CONTATO": 1,
  "UUID": "e5f6a7b8-c9d0-1234-ef56-7890abcdef12",
  "EMPRESA_ID": 1,
  "NOME": "José Santos",
  "CARGO": "Gerente Administrativo",
  "TELEFONE": "1130002222",
  "EMAIL": "jose@exemplo.com",
  "WHATSAPP": "11988886666",
  "PRINCIPAL": 1,
  "CRIADO_EM": "2025-01-10 09:00:00",
  "ATUALIZADO_EM": "2025-01-10 09:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
