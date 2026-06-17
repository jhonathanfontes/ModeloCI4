# CLIE_ENDERECOS

## Objetivo
Armazenar endereços dos clientes. Permite múltiplos endereços por cliente,
classificados por tipo (SIST_TIPOS).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_ENDERECO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do endereço (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| CLIENTE_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para CLIENTES |
| TIPO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_TIPOS (ex: Residencial, Comercial) |
| CEP | VARCHAR(8) | NOT NULL | CEP, apenas números |
| LOGRADOURO | VARCHAR(255) | NOT NULL | Logradouro do endereço |
| NUMERO | VARCHAR(20) | NOT NULL | Número |
| COMPLEMENTO | VARCHAR(100) | NULL | Complemento |
| BAIRRO | VARCHAR(120) | NOT NULL | Bairro |
| CIDADE | VARCHAR(120) | NOT NULL | Cidade |
| UF | CHAR(2) | NOT NULL | Sigla da unidade federativa (caixa alta) |
| PRINCIPAL | TINYINT(1) | NOT NULL | Indica se é o endereço principal do cliente |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_ENDERECO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | CLIENTE_ID | CLIENTES(ID_CLIENTE) |
| FOREIGN KEY | TIPO_ID | SIST_TIPOS(ID_TIPO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CEP` armazenado apenas números (8 dígitos).
- `UF` armazenado em caixa alta fixo (2 caracteres).
- `PRINCIPAL` = 1 indica endereço principal. Deve haver no máximo 1 principal por cliente.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_ENDERECO": 1,
  "UUID": "f6a7b8c9-d0e1-2345-f678-90abcdef1234",
  "CLIENTE_ID": 1,
  "TIPO_ID": 1,
  "CEP": "20040030",
  "LOGRADOURO": "Rua do Ouvidor",
  "NUMERO": "100",
  "COMPLEMENTO": null,
  "BAIRRO": "Centro",
  "CIDADE": "Rio de Janeiro",
  "UF": "RJ",
  "PRINCIPAL": 1,
  "CRIADO_EM": "2025-01-15 10:00:00",
  "ATUALIZADO_EM": "2025-01-15 10:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
