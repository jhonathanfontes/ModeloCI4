# AUDI_AUDITORIA

## Objetivo
Auditoria principal do sistema — registra todas as operações de INSERT, UPDATE e DELETE
realizadas nas tabelas do sistema. Armazena o estado anterior e posterior dos registros
afetados, permitindo rastrear quem alterou o quê e quando.

Banco de dados: `logger_ci4` (conexão separada).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_AUDITORIA | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do registro de auditoria (PK) |
| TABELA | VARCHAR(100) | NOT NULL | Nome da tabela onde a operação foi executada |
| TABELA_ID | BIGINT UNSIGNED | NOT NULL | ID do registro afetado na tabela de origem |
| OPERACAO | VARCHAR(20) | NOT NULL | Tipo de operação: INSERT, UPDATE ou DELETE |
| DADOS_ANTERIORES | JSON | NULL | Estado completo do registro antes da alteração |
| DADOS_NOVOS | JSON | NULL | Estado completo do registro após a alteração |
| USUARIO_ID | BIGINT UNSIGNED | NULL | ID do usuário que executou a operação (referência a SEGU_USUARIOS sem FK) |
| ENDERECO_IP | VARCHAR(45) | NULL | Endereço IP de origem da requisição (IPv4 ou IPv6) |
| USER_AGENT | VARCHAR(500) | NULL | User-Agent do navegador ou cliente HTTP |
| URL_ORIGEM | VARCHAR(500) | NULL | URL de origem da requisição |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora exata em que a operação foi registrada |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_AUDITORIA | — |
| INDEX | TABELA | — |
| INDEX | TABELA_ID | — |
| INDEX | USUARIO_ID | — |
| INDEX | CRIADO_EM | — |

## Regras de Negócio

- Tabela append-only: registros nunca são alterados ou excluídos fisicamente.
- `OPERACAO` restrita a: INSERT, UPDATE, DELETE.
- `USUARIO_ID` é uma referência lógica (sem FK) porque a tabela reside em banco separado.
- `DADOS_ANTERIORES` é NULL para operações INSERT.
- `DADOS_NOVOS` é NULL para operações DELETE.

## Payload de Exemplo

```json
{
  "ID_AUDITORIA": 1,
  "TABELA": "CLIENTES",
  "TABELA_ID": 42,
  "OPERACAO": "UPDATE",
  "DADOS_ANTERIORES": {"NOME": "João Silva", "EMAIL": "joao@email.com", "SITUACAO_ID": 1},
  "DADOS_NOVOS": {"NOME": "João Santos", "EMAIL": "joao.novo@email.com", "SITUACAO_ID": 1},
  "USUARIO_ID": 1,
  "ENDERECO_IP": "192.168.1.100",
  "USER_AGENT": "Mozilla/5.0...",
  "URL_ORIGEM": "/clientes/atualizar/42",
  "CRIADO_EM": "2025-06-17 10:30:00"
}
```
