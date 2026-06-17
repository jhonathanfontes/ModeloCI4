# EMPRESAS

## Objetivo
Cadastro central de empresas/clientes corporativos do sistema. Entidade
raiz do modelo multi-tenant: toda operação pertence a uma empresa.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_EMPRESA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da empresa (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| RAZAO_SOCIAL | VARCHAR(255) | NOT NULL | Razão social jurídica e oficial da empresa |
| NOME_FANTASIA | VARCHAR(255) | NOT NULL | Nome fantasia / nome de divulgação |
| CNPJ | VARCHAR(14) | NOT NULL | CNPJ da empresa (apenas números, UNIQUE) |
| EMAIL | VARCHAR(255) | NOT NULL | E-mail corporativo principal de contato |
| TELEFONE | VARCHAR(15) | NOT NULL | Telefone fixo corporativo (com DDD, apenas números) |
| CELULAR | VARCHAR(15) | NOT NULL | Celular corporativo (com DDD, apenas números) |
| CEP | VARCHAR(8) | NOT NULL | CEP do endereço sede (apenas números) |
| LOGRADOURO | VARCHAR(255) | NOT NULL | Logradouro do endereço sede |
| NUMERO | VARCHAR(20) | NOT NULL | Número do endereço sede |
| COMPLEMENTO | VARCHAR(100) | NULL | Complemento do endereço sede |
| BAIRRO | VARCHAR(120) | NOT NULL | Bairro do endereço sede |
| CIDADE | VARCHAR(120) | NOT NULL | Cidade do endereço sede |
| UF | CHAR(2) | NOT NULL | Sigla da unidade federativa (caixa alta) |
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
| PRIMARY KEY | ID_EMPRESA | — |
| UNIQUE | UUID | — |
| UNIQUE | CNPJ | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CNPJ` armazenado apenas números (14 dígitos), validado na aplicação.
- `CEP` armazenado apenas números (8 dígitos).
- `UF` armazenado em caixa alta fixo (2 caracteres).
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).
- Nenhuma cascade em FKs; usar `ON DELETE RESTRICT`.

## Payload de Exemplo

```json
{
  "ID_EMPRESA": 1,
  "UUID": "b2c3d4e5-f6a7-8901-bcde-f12345678901",
  "RAZAO_SOCIAL": "Empresa Exemplo Ltda",
  "NOME_FANTASIA": "Exemplo",
  "CNPJ": "11222333000181",
  "EMAIL": "contato@exemplo.com",
  "TELEFONE": "1130001111",
  "CELULAR": "11988887777",
  "CEP": "01001000",
  "LOGRADOURO": "Av. Paulista",
  "NUMERO": "1000",
  "COMPLEMENTO": "Sala 501",
  "BAIRRO": "Bela Vista",
  "CIDADE": "São Paulo",
  "UF": "SP",
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-01 00:00:00",
  "ATUALIZADO_EM": "2025-01-15 10:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
