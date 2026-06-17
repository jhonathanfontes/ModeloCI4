# MENU_MODULOS

## Objetivo
Catálogo de módulos do sistema (ex: Cadastro, Financeiro, Relatórios, Configurações).
Define a estrutura hierárquica do menu de navegação.

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_MODULO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do módulo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME | VARCHAR(100) | NOT NULL | Nome do módulo para exibição no menu |
| DESCRICAO | TEXT | NULL | Descrição detalhada do módulo |
| ICONE | VARCHAR(50) | NULL | Classe do ícone (FontAwesome/Material) |
| URL_ROTA | VARCHAR(255) | NULL | Rota principal do módulo |
| ORDEM | INT | NULL | Ordem de exibição no menu |
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
| PRIMARY KEY | ID_MODULO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- Módulos com `EXCLUIDO_EM` preenchido não são exibidos no menu.
- `ORDEM` define a posição relativa entre módulos.

## Payload de Exemplo

```json
{
  "ID_MODULO": 1,
  "UUID": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
  "NOME": "Cadastro",
  "DESCRICAO": "Gestão de clientes, fornecedores e produtos",
  "ICONE": "fa-users",
  "URL_ROTA": "/cadastro",
  "ORDEM": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
