# SIST_PLANOS

## Objetivo
Planos de assinatura do sistema (ex: Gratuito, Básico, Profissional, Enterprise).
Define limites de uso e recursos disponíveis para cada locatário (empresa).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_PLANO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do plano (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(100) | NOT NULL | Nome do plano (ex: Básico, Premium) |
| DESCRICAO | TEXT | NULL | Descrição detalhada dos recursos do plano |
| VALOR | DECIMAL(10,2) | NOT NULL | Valor mensal do plano |
| PERIODO_ID | BIGINT UNSIGNED | NULL | Chave estrangeira para SIST_TIPOS (ex: mensal, anual) |
| LIMITE_CLIENTES | INT UNSIGNED | NULL | Número máximo de clientes permitido (NULL = ilimitado) |
| LIMITE_USUARIOS | INT UNSIGNED | NULL | Número máximo de usuários permitido |
| LIMITE_ARMAZENAMENTO_MB | INT UNSIGNED | NULL | Limite de armazenamento em MB |
| SITUACAO | TINYINT(1) | NOT NULL | Indica se o plano está ativo (1) ou inativo (0) |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora de inserção do registro |
| ATUALIZADO_EM | DATETIME | NOT NULL | Data e hora da última modificação |
| EXCLUIDO_EM | DATETIME | NULL | Data de exclusão lógica (Soft Delete) |
| CRIADO_POR | BIGINT UNSIGNED | NULL | ID do usuário que criou o registro |
| ATUALIZADO_POR | BIGINT UNSIGNED | NULL | ID do último usuário que alterou o registro |
| EXCLUIDO_POR | BIGINT UNSIGNED | NULL | ID do usuário que executou a exclusão lógica |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_PLANO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | PERIODO_ID | SIST_TIPOS(ID_TIPO) |
| — | SITUACAO | — |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `VALOR` é armazenado em reais (BRL) com duas casas decimais.
- Limites com valor `NULL` significam "sem restrição".
- `PERIODO_ID` referencia SIST_TIPOS filtrando por tipo "periodo_plano".
- `SITUACAO` 1 = ativo, 0 = inativo (não utiliza SIST_SITUACOES).

## Payload de Exemplo

```json
{
  "ID_PLANO": 1,
  "UUID": "a7b8c9d0-e1f2-3456-abcd-567890123456",
  "NOME": "Profissional",
  "DESCRICAO": "Para empresas em crescimento",
  "VALOR": 149.90,
  "PERIODO_ID": 1,
  "LIMITE_CLIENTES": 500,
  "LIMITE_USUARIOS": 10,
  "LIMITE_ARMAZENAMENTO_MB": 1024,
  "SITUACAO": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
