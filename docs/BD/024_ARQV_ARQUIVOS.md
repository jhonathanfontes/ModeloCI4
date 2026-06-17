# ARQV_ARQUIVOS

## Objetivo
Registro central de arquivos enviados ao sistema (documentos, imagens, anexos).
Permite rastrear o nome original, localização física, tipo MIME e entidade
associada (tabela + ID polimórfico).

## Dicionário de dados

| Campo | Tipo | Nulidade | Comentário |
|---|---|---|---|
| ID_ARQUIVO | BIGINT UNSIGNED | NOT NULL | Identificador único sequencial do arquivo (PK) |
| UUID | CHAR(36) | NOT NULL | Identificador único público universal (UUID4) |
| NOME_ORIGINAL | VARCHAR(255) | NOT NULL | Nome original do arquivo no momento do upload |
| NOME_ARMAZENADO | VARCHAR(255) | NOT NULL | Nome gerado para armazenamento no disco |
| CAMINHO | VARCHAR(500) | NOT NULL | Caminho relativo dentro do diretório de uploads |
| TIPO_MIME | VARCHAR(100) | NOT NULL | Tipo MIME do arquivo (ex: application/pdf, image/png) |
| TAMANHO | BIGINT UNSIGNED | NOT NULL | Tamanho do arquivo em bytes |
| EXTENSAO | VARCHAR(10) | NOT NULL | Extensão do arquivo (ex: pdf, png, jpg) |
| TABELA | VARCHAR(100) | NULL | Nome da tabela associada (referência polimórfica) |
| TABELA_ID | BIGINT UNSIGNED | NULL | ID do registro na tabela associada |
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
| PRIMARY KEY | ID_ARQUIVO | — |
| UNIQUE | UUID | — |
| FOREIGN KEY | SITUACAO_ID | SIST_SITUACOES(ID_SITUACAO) |
| FOREIGN KEY | CRIADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | ATUALIZADO_POR | SEGU_USUARIOS(ID_USUARIO) |
| FOREIGN KEY | EXCLUIDO_POR | SEGU_USUARIOS(ID_USUARIO) |

## Regras de Negócio

- `TABELA` + `TABELA_ID` formam uma referência polimórfica (ex: TABELA='CLIENTES', TABELA_ID=1).
- O arquivo físico deve ser excluído do disco SOMENTE após a exclusão lógica.
- `NOME_ARMAZENADO` deve ser único no disco (recomendado: UUID + extensão).

## Payload de Exemplo

```json
{
  "ID_ARQUIVO": 1,
  "UUID": "a3b4c5d6-e7f8-9012-abcd-123456789012",
  "NOME_ORIGINAL": "contrato.pdf",
  "NOME_ARMAZENADO": "a1b2c3d4-e5f6-7890-abcd-ef1234567890.pdf",
  "CAMINHO": "uploads/empresas/1/documentos/",
  "TIPO_MIME": "application/pdf",
  "TAMANHO": 1048576,
  "EXTENSAO": "pdf",
  "TABELA": "CLIENTES",
  "TABELA_ID": 1,
  "SITUACAO_ID": 1,
  "CRIADO_EM": "2025-01-20 14:30:00"
}
```
