# EMPR_ENDERECOS

## Objetivo
Armazenar endereços das empresas (matriz, filiais, etc.). Permite múltiplos
endereços por empresa, classificados por tipo (SIST_TIPOS).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_ENDERECO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do endereço (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| TIPO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_TIPOS (ex: Matriz, Filial) |
| CEP | VARCHAR(8) | NOT NULL | CEP, apenas números |
| LOGRADOURO | VARCHAR(255) | NOT NULL | Logradouro do endereço |
| NUMERO | VARCHAR(20) | NOT NULL | Número |
| COMPLEMENTO | VARCHAR(100) | NULL | Complemento |
| BAIRRO | VARCHAR(120) | NOT NULL | Bairro |
| CIDADE | VARCHAR(120) | NOT NULL | Cidade |
| UF | CHAR(2) | NOT NULL | Sigla da unidade federativa (caixa alta) |
| PRINCIPAL | TINYINT(1) | NOT NULL | Indica se é o endereço principal da empresa |
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
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | TIPO_ID | SIST_TIPOS(ID_TIPO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CEP` armazenado apenas números (8 dígitos).
- `UF` armazenado em caixa alta fixo (2 caracteres).
- `PRINCIPAL` = 1 indica endereço principal. Deve haver no máximo 1 principal por empresa.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_ENDERECO": 1,
  "UUID": "d4e5f6a7-b8c9-0123-def4-567890abcdef",
  "EMPRESA_ID": 1,
  "TIPO_ID": 1,
  "CEP": "01311000",
  "LOGRADOURO": "Av. Paulista",
  "NUMERO": "1500",
  "COMPLEMENTO": "Conj 201",
  "BAIRRO": "Bela Vista",
  "CIDADE": "São Paulo",
  "UF": "SP",
  "PRINCIPAL": 1,
  "CRIADO_EM": "2025-01-10 09:00:00",
  "ATUALIZADO_EM": "2025-01-10 09:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
