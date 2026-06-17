# ORGA_DEPARTAMENTOS

## Objetivo
Departamentos organizacionais de cada empresa (ex: Financeiro, RH, TI, Comercial).
Permite estruturar hierarquicamente a organização.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_DEPARTAMENTO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do departamento (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| EMPRESA_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para EMPRESAS |
| NOME | VARCHAR(100) | NOT NULL | Nome do departamento (ex: Recursos Humanos) |
| SIGLA | VARCHAR(10) | NULL | Sigla do departamento (ex: RH) |
| GESTOR_ID | BIGINT UNSIGNED | NULL | Chave estrangeira para SEGU_USUARIOS (gestor responsável) |
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
| PRIMARY KEY | ID_DEPARTAMENTO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | EMPRESA_ID | EMPRESAS(ID_EMPRESA) |
| FOREIGN KEY | GESTOR_ID | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- Um departamento pertence a exatamente uma empresa.
- `GESTOR_ID` é opcional e vincula ao usuário gestor do departamento.
- Exclusão lógica mantém o histórico.

## Payload de Exemplo

```json
{
  "ID_DEPARTAMENTO": 1,
  "UUID": "d0e1f2a3-b4c5-6789-defa-890123456789",
  "EMPRESA_ID": 1,
  "NOME": "Tecnologia da Informação",
  "SIGLA": "TI",
  "GESTOR_ID": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
