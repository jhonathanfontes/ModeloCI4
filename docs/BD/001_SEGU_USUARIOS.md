# SEGU_USUARIOS

## Objetivo
Armazenar as contas de usuário do sistema (admin, empresas, clientes). Tabela
central de autenticação, controle de sessão e rastreamento de auditoria.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_USUARIO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do usuário (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(255) | NOT NULL | Nome completo do usuário |
| EMAIL | VARCHAR(255) | NOT NULL | E-mail de login do usuário (UNIQUE) |
| SENHA_HASH | VARCHAR(255) | NOT NULL | Hash da senha (BCRYPT) |
| TIPO | VARCHAR(30) | NOT NULL | Tipo de conta: SYSTEM, EMPRESA, CLIENTE |
| ULTIMO_LOGIN | DATETIME | NULL | Data e hora do último login bem-sucedido |
| ULTIMO_IP | VARCHAR(45) | NULL | Endereço IP do último acesso |
| EMAIL_VERIFICADO_EM | DATETIME | NULL | Data de verificação do e-mail |
| TENTATIVAS_LOGIN | INT | NOT NULL | Contador de tentativas de login falhas consecutivas |
| BLOQUEADO_ATE | DATETIME | NULL | Bloqueio temporário por excesso de tentativas |
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
| PRIMARY KEY | ID_USUARIO | — |
| UNIQUE | UUID | — |
| UNIQUE | EMAIL | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `TIPO` restrito a: SYSTEM, EMPRESA, CLIENTE.
- `SENHA_HASH` deve utilizar algoritmo BCRYPT.
- `TENTATIVAS_LOGIN` incrementa a cada falha; zera após login bem-sucedido.
- `BLOQUEADO_ATE` ativado quando `TENTATIVAS_LOGIN >= 5`.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete nativo CI4).

## Payload de Exemplo

```json
{
  "ID_USUARIO": 1,
  "UUID": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
  "NOME": "João da Silva",
  "EMAIL": "joao@exemplo.com",
  "SENHA_HASH": "$2y$10$...",
  "TIPO": "EMPRESA",
  "ULTIMO_LOGIN": "2025-01-15 08:30:00",
  "ULTIMO_IP": "192.168.1.100",
  "EMAIL_VERIFICADO_EM": "2025-01-10 14:00:00",
  "TENTATIVAS_LOGIN": 0,
  "BLOQUEADO_ATE": null,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-01 00:00:00",
  "ATUALIZADO_EM": "2025-01-15 08:30:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": null,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
