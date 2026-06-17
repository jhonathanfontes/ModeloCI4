# AUDI_LOGS

## Objetivo
Registro de logs de aplicação em diferentes níveis (DEBUG, INFO, WARNING, ERROR, CRITICAL).
Armazena mensagens do sistema, erros de processo e informações contextuais para
diagnóstico e monitoramento.

Banco de dados: `logger_ci4` (conexão separada).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_LOG | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do log (PK) |
| NIVEL | VARCHAR(20) | NOT NULL | Nível do log: DEBUG, INFO, WARNING, ERROR, CRITICAL |
| MENSAGEM | TEXT | NOT NULL | Mensagem descritiva do evento |
| CONTEXTO | JSON | NULL | Dados contextuais adicionais em formato JSON |
| TABELA | VARCHAR(100) | NULL | Nome da tabela associada ao evento (referência lógica) |
| TABELA_ID | BIGINT UNSIGNED | NULL | ID do registro associado ao evento |
| USUARIO_ID | BIGINT UNSIGNED | NULL | ID do usuário relacionado ao evento (referência lógica) |
| ENDERECO_IP | VARCHAR(45) | NULL | Endereço IP de origem da requisição |
| URL_ORIGEM | VARCHAR(500) | NULL | URL de origem da requisição |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora exata em que o log foi gerado |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_LOG | — |
| INDEX | NIVEL | — |
| INDEX | USUARIO_ID | — |
| INDEX | CRIADO_EM | — |

## Regras de Negócio

- Tabela append-only: registros nunca são alterados ou excluídos.
- `NIVEL` restrito a: DEBUG, INFO, WARNING, ERROR, CRITICAL.
- `CONTEXTO` pode conter qualquer estrutura JSON (stack trace, parâmetros, etc.).
- Índice em `CRIADO_EM` para consultas por período.

## Payload de Exemplo

```json
{
  "ID_LOG": 1,
  "NIVEL": "ERROR",
  "MENSAGEM": "Falha ao processar pagamento: timeout na gateway",
  "CONTEXTO": {"metodo": "POST", "rota": "/api/pagamentos", "status_code": 504},
  "TABELA": "FINA_PAGAMENTOS",
  "TABELA_ID": 99,
  "USUARIO_ID": 1,
  "ENDERECO_IP": "192.168.1.100",
  "URL_ORIGEM": "/api/pagamentos",
  "CRIADO_EM": "2025-06-17 10:30:00"
}
```
