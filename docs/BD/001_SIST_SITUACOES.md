# SIST_SITUACOES

## Objetivo
Tabela global e parametrizada de situações/estados dos registros do sistema.
Substitui completamente o uso de ENUMs. Cada módulo possui seu conjunto de
situações (ex: ATIVO, INATIVO, PENDENTE, CANCELADO, BLOQUEADO, CONCLUIDO).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_SITUACAO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial da situação (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| MODULO | VARCHAR(100) | NOT NULL | Agrupador do contexto da situação (ex: EMPRESAS, USUARIOS) |
| CODIGO | VARCHAR(50) | NOT NULL | Código textual da situação (ex: ATIVO, INATIVO, PENDENTE) |
| DESCRICAO | VARCHAR(255) | NOT NULL | Descrição amigável da situação |
| COR | VARCHAR(20) | NULL | Cor hexadecimal para representação visual (ex: #28a745) |
| ICONE | VARCHAR(50) | NULL | Ícone para representação visual |
| FINALIZADORA | TINYINT(1) | NOT NULL | Indica se é uma situação finalizadora (não permite transição p/ outra) |
| CONCLUIDA | TINYINT(1) | NOT NULL | Indica se o registro foi concluído com sucesso |
| CANCELADA | TINYINT(1) | NOT NULL | Indica se o registro foi cancelado |
| PENDENTE | TINYINT(1) | NOT NULL | Indica se o registro está pendente de ação |
| BLOQUEIA_EDICAO | TINYINT(1) | NOT NULL | Bloqueia edição do registro quando True |
| GERA_HISTORICO | TINYINT(1) | NOT NULL | Gera entrada em AUDI_HISTORICOS ao transicionar para esta situação |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_SITUACAO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `CODIGO` + `MODULO` formam uma combinação única (uma situação por módulo).
- `FINALIZADORA` = 1 impede transições para outras situações (via SIST_TRANSICOES).
- `PENDENTE` = 1 é o valor padrão para novos registros.
- `BLOQUEIA_EDICAO` = 1 impede alterações no registro pela aplicação.
- Exclusão é lógica via `EXCLUIDO_EM` (Soft Delete).

## Payload de Exemplo

```json
{
  "ID_SITUACAO": 1,
  "UUID": "b1c2d3e4-f5a6-7890-abcd-ef1234567890",
  "MODULO": "EMPRESAS",
  "CODIGO": "ATIVO",
  "DESCRICAO": "Empresa ativa e operacional",
  "COR": "#28a745",
  "ICONE": "check-circle",
  "FINALIZADORA": 0,
  "CONCLUIDA": 0,
  "CANCELADA": 0,
  "PENDENTE": 0,
  "BLOQUEIA_EDICAO": 0,
  "GERA_HISTORICO": 1,
  "CRIADO_EM": "2025-01-01 00:00:00",
  "ATUALIZADO_EM": "2025-01-01 00:00:00",
  "EXCLUIDO_EM": null,
  "CRIADO_POR": null,
  "ATUALIZADO_POR": null,
  "EXCLUIDO_POR": null
}
```
