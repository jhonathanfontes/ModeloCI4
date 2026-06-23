# EMPR_EMPRESA_SERVICOS

## Objetivo
Tabela pivô que associa serviços (`MENU_SERVICOS`) às empresas (`EMPRESAS`), permitindo ativar/desativar serviços específicos por empresa, sobrescrevendo os defaults do plano.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_EMPRESA_SERVICO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | FK → EMPRESAS(ID_EMPRESA) |
| SERVICO_ID | BIGINT UNSIGNED | NOT NULL | FK → MENU_SERVICOS(ID_SERVICO) |
| ATIVO | TINYINT(1) | NOT NULL | 1 = ativo, 0 = inativo |
| CRIADO_EM | DATETIME | NOT NULL | Data de inserção |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Soft Delete |
| CRIADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | FK → SEGU_USUARIOS(ID_USUARIO) |

## Mapeamento de Restrições

| Tipo | Coluna(s) | Referência |
|---|---|---|
| PRIMARY KEY | ID_EMPRESA_SERVICO | — |
| UNIQUE | UUID | — |
| UNIQUE | (EMPRESA_ID, SERVICO_ID) | — |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | SERVICO_ID | MENU_SERVICOS(ID_SERVICO) |

## Payload de Exemplo

```json
{
  "ID_EMPRESA_SERVICO": 1,
  "UUID": "b2c3d4e5-f6a7-8901-bcde-234567890123",
  "EMPRESA_ID": 1,
  "SERVICO_ID": 5,
  "ATIVO": 1
}
```
