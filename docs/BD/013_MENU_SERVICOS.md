# MENU_SERVICOS

## Objetivo
Serviços/funcionalidades agrupadas dentro de cada módulo (ex: em Cadastro → Clientes, Fornecedores, Produtos).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_SERVICO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do serviço (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| MODULO_ID | BIGINT UNSIGNED | NOT NULL | Chave estrangeira para MENU_MODULOS |
| NOME | VARCHAR(100) | NOT NULL | Nome do serviço para exibição |
| DESCRICAO | TEXT | NULL | Descrição detalhada do serviço |
| URL_ROTA | VARCHAR(255) | NULL | Rota padrão do serviço |
| ICONE | VARCHAR(50) | NULL | Classe do ícone (FontAwesome/Material) |
| ORDEM | INT | NULL | Ordem de exibição dentro do módulo |
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
| PRIMARY KEY | ID_SERVICO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | MODULO_ID | MENU_MODULOS(ID_MODULO) |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- Um serviço pertence a exatamente um módulo.
- `ORDEM` define a posição relativa dentro do módulo.

## Payload de Exemplo

```json
{
  "ID_SERVICO": 1,
  "UUID": "b2c3d4e5-f6a7-8901-bcde-f12345678901",
  "MODULO_ID": 1,
  "NOME": "Clientes",
  "DESCRICAO": "Cadastro e gestão de clientes",
  "URL_ROTA": "/cadastro/clientes",
  "ICONE": "fa-user",
  "ORDEM": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
