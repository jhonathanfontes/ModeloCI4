# CLIENTES

## Objetivo
Cadastro de clientes das empresas (pessoas físicas ou jurídicas). Entidade
vinculada diretamente a uma empresa e classificada por tipo (SIST_TIPOS).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_CLIENTE | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do cliente (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| PESSOA_ID | BIGINT UNSIGNED | NULL | Chave estrangeira para PESSOAS (CPF/CNPJ compartilhado) |
| TIPO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_TIPOS (classificação) |
| SITUACAO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para SIST_SITUACOES |
| NOME | VARCHAR(255) | NOT NULL | Nome completo do cliente (pessoa física) ou razão social (jurídica) |
| NOME_FANTASIA | VARCHAR(255) | NULL | Nome fantasia (pessoa jurídica) |
| CPF_CNPJ | VARCHAR(14) | NOT NULL | CPF (11 dígitos) ou CNPJ (14 dígitos), apenas números. Denormalizado de PESSOAS |
| DATA_NASCIMENTO | DATE | NULL | Data de nascimento (pessoa física) |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_CLIENTE | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | PESSOA_ID | PESSOAS(ID_PESSOA) |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | TIPO_ID | SIST_TIPOS(ID_TIPO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CPF_CNPJ` armazenado apenas números (11 ou 14 dígitos); validado na aplicação. Denormalizado de PESSOAS para consulta.
- Se `CPF_CNPJ` tiver 11 dígitos → CPF (pessoa física); se 14 → CNPJ (jurídica).
- `PESSOA_ID` vincula ao registro central em PESSOAS. Múltiplos CLIENTES podem compartilhar a mesma PESSOA (mesmo CPF/CNPJ).
- A unicidade de CPF/CNPJ é garantida pela tabela PESSOAS.
- `TIPO_ID` vincula à classificação em SIST_TIPOS (ex: PF, PJ, etc.).
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).
- Nenhuma cascade em FKs; usar `ON DELETE RESTRICT`.

## Payload de Exemplo

```json
{
  "ID_CLIENTE": 1,
  "UUID": "c3d4e5f6-a7b8-9012-cdef-123456789abc",
  "EMPRESA_ID": 1,
  "PESSOA_ID": 1,
  "TIPO_ID": 1,
  "SITUACAO_ID": 1,
  "NOME": "Maria Oliveira",
  "NOME_FANTASIA": null,
  "CPF_CNPJ": "12345678901",
  "DATA_NASCIMENTO": "1990-05-20",
  "CRIADO_EM": "2025-01-10 09:00:00",
  "ATUALIZADO_EM": "2025-01-10 09:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": 1,
  "ATUALIZADO_POR": 1,
  "EXCLUIDO_POR": null
}
```
