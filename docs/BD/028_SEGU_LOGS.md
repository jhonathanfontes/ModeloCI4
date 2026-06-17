# SEGU_LOGS

## Objetivo
Registro de eventos de segurança — autenticação, autorização, bloqueios de conta,
tentativas de acesso indevido e outras atividades relacionadas à segurança do sistema.

Banco de dados: `logger_ci4` (conexão separada).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_LOG | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do log de segurança (PK) |
| TIPO_EVENTO | VARCHAR(50) | NOT NULL | Tipo do evento: LOGIN, LOGOUT, LOGIN_FALHO, BLOQUEIO, PERMISSAO_ALTERADA, etc. |
| USUARIO_ID | BIGINT UNSIGNED | NULL | ID do usuário envolvido no evento (referência lógica) |
| USERNAME | VARCHAR(100) | NULL | Nome de usuário informado no momento do evento (útil quando o login falha) |
| EMAIL | VARCHAR(255) | NULL | E-mail informado no momento do evento |
| MENSAGEM | TEXT | NOT NULL | Descrição detalhada do evento de segurança |
| ENDERECO_IP | VARCHAR(45) | NULL | Endereço IP de origem do evento |
| USER_AGENT | VARCHAR(500) | NULL | User-Agent do cliente HTTP |
| SUCESSO | TINYINT(1) | NULL | 1 = operação bem-sucedida, 0 = falha, NULL = não se aplica |
| CRIADO_EM | DATETIME | NOT NULL | Data e hora exata do evento |

## Mapeamento de Restrições

| Tipo | Coluna | Referência |
|---|---|---|
| PRIMARY KEY | ID_LOG | — |
| INDEX | TIPO_EVENTO | — |
| INDEX | USUARIO_ID | — |
| INDEX | SUCESSO | — |
| INDEX | CRIADO_EM | — |

## Regras de Negócio

- Tabela append-only: registros nunca são alterados ou excluídos.
- `USERNAME` é registrado mesmo quando o login falha (antes de identificar o USUARIO_ID).
- `SUCESSO` permite filtrar eventos bem-sucedidos vs. tentativas frustradas.

## Payload de Exemplo

```json
{
  "ID_LOG": 1,
  "TIPO_EVENTO": "LOGIN_FALHO",
  "USUARIO_ID": null,
  "USERNAME": "joao.silva",
  "EMAIL": "joao@email.com",
  "MENSAGEM": "Tentativa de login com senha inválida — 3ª tentativa consecutiva",
  "ENDERECO_IP": "192.168.1.100",
  "USER_AGENT": "Mozilla/5.0...",
  "SUCESSO": 0,
  "CRIADO_EM": "2025-06-17 10:30:00"
}
```
