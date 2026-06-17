# ModeloBF2 — Agent Guide

## Project identity

**CodeIgniter 4.7.3** PHP web app (`php ^8.2`). Not a monorepo.  
Multi-tenant enterprise SaaS scaffold — most app directories are empty, module structure is laid out.

## Quick commands

| Action | Command |
|--------|---------|
| Test suite | `phpunit` or `composer test` |
| Static analysis | `vendor/bin/phpstan` (level 5, excludes `app/Views/*`) |
| Code style | `vendor/bin/php-cs-fixer fix` (PSR-12, short arrays, alpha imports) |
| Auto-refactor | `vendor/bin/rector process` (UP_TO_PHP_82, code quality, dead code) |
| CLI entry | `php spark` (scaffolding, migrations, etc.) |
| Dev server | `php spark serve` |

## Architecture

- **Front controller:** `public/index.php` (not root)
- **Auto-routing is OFF** — use controller route attributes
- Only one route defined: `GET / → Home::index` (`app/Config/Routes.php`)
- **Modules** live under `app/Modulos/` — copy `_Modelo/` as a starting template for new modules (same subdirs: DTO, Entities, Events, Models, Repositories, Rules, Services, Validators)
- `app/Config/Services.php` registers custom services: `twig()`, `imageManager()`, `redis()`
- PSR-4: `App\` → `app/`, `Config\` → `app/Config/`
- Namespace `App\\Config\\Services` for service accessors (CI4 convention)

## Database conventions

- All names in **UPPERCASE** (`SNAKE_CASE`), no special chars or accents
- **PK:** `ID_{ENTIDADE_SINGULAR}` (`ID_EMPRESA`, `ID_CLIENTE`) — BIGINT UNSIGNED AUTO_INCREMENT
- **FK:** `{ENTIDADE_SINGULAR}_ID` (`EMPRESA_ID`, `CLIENTE_ID`) — BIGINT UNSIGNED, must match PK type exactly
- **UUID:** `UUID CHAR(36)` required on all principal entities (exposed via API/URL)
- **Plural** for main entities (`EMPRESAS`, `CLIENTES`); pivot tables combine related names (`EMPR_GRUPO_EMPRESAS`)
- **No ENUM** — use `SITUACAO_ID` FK → `SIST_SITUACOES(ID_SITUACAO)` for all record states
- **FK rules:** `ON DELETE RESTRICT` (no CASCADE on operational/financial tables); every FK column must have an INDEX
- **All tables** must end with these 6 audit fields:

  ```
  CRIADO_EM DATETIME NOT NULL
  ATUALIZADO_EM DATETIME NOT NULL
  EXCLUIDO_EM DATETIME NULL
  CRIADO_POR BIGINT UNSIGNED NULL  → SEGU_USUARIOS(ID_USUARIO)
  ATUALIZADO_POR BIGINT UNSIGNED NULL
  EXCLUIDO_POR BIGINT UNSIGNED NULL
  ```

- **Standardized column types** — see `Documentacao/BD.md` for the full table (CNPJ=VARCHAR(14), CPF=VARCHAR(11), CEP=VARCHAR(8), UF=CHAR(2), etc.)
- **Migrations** live in `app/Database/Migrations/` (excluded from autoloader classmap); **every field** must include a `'comment'` key
- **Documentation first** — before any migration, create a model doc in `docs/BD/{NNN}_{TABELA}.md` with: purpose, field dictionary, PK/UK/FK mapping, business rules, example JSON payload
- **Logger DB** (`logger_ci4`, separate connection) for audit/history tables: `AUDI_AUDITORIA`, `AUDI_LOGS`, `AUDI_HISTORICOS`, `SEGU_LOGS`
- Multi-tenant via `EMPRESAS` + `SEGU_ACCOUNTS` / `USUA_USUARIO_EMPRESAS`

## Testing

- PHPUnit 10.5, config in `phpunit.dist.xml` (copy to `phpunit.xml` to customize)
- **DB tests use SQLite `:memory:`** by default (override via `phpunit.xml` env vars)
- Test namespace: `Tests\Support\` → `tests/_support`
- Run single test: `phpunit tests/unit/HealthTest.php`
- DB test example: `tests/database/ExampleDatabaseTest.php` uses `DatabaseTestTrait`

## Build / env

- `./builds` script toggles `composer.json` between stable release, dev branch, and next version of the framework
- `.env` active with `CI_ENVIRONMENT = development`; `env` file is the commented template
- `writable/` used for cache, logs, sessions, uploads, debugbar

## Key dependencies

- `dompdf/dompdf` (PDF generation)
- `firebase/php-jwt` (JWT auth, configurable in `app/Config/JWT.php`)
- `intervention/image` (image manipulation via `imageManager()` service)
- `phpoffice/phpspreadsheet` (spreadsheets)
- `predis/predis` (Redis, accessed via `redis()` service)
- `twig/twig` (templating via `twig()` service, with caching)
- `zircote/swagger-php` (API documentation)
- `codeigniter4/queue` (queues: database, Redis, Predis, RabbitMQ)
