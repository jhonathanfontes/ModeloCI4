# ModeloBF2 — Developer & Agent Instructions

This document serves as the foundational authority and instructional context for all development on **ModeloBF2**. It establishes the architecture, database conventions, development workflows, testing guidelines, and quality standards for this multi-tenant enterprise SaaS scaffold.

---

## 1. Project Overview & Tech Stack

ModeloBF2 is a highly structured, multi-tenant enterprise SaaS scaffold built on **CodeIgniter 4.7.3** running on **PHP ^8.2**.

### Key Technologies & Libraries
- **Framework:** CodeIgniter 4.7.3 (Auto-routing is **OFF**; routing is strictly configured in `app/Config/Routes.php` and Controller route attributes)
- **Database:** Standard SQL / Relational. Includes a dedicated `logger_ci4` connection for audit logs. SQLite is used for database tests in-memory.
- **Templating:** Twig (`twig/twig ^3.27`) accessed via `twig()` custom service wrapper.
- **Caching & Queueing:** Redis (`predis/predis ^3.5`) via `redis()` service and CodeIgniter Queue library (`codeigniter4/queue ^1.0`).
- **Additional Libraries:**
  - `dompdf/dompdf`: PDF generation.
  - `firebase/php-jwt`: JWT authentication, configured in `app/Config/JWT.php`.
  - `intervention/image`: Image processing using the `imageManager()` service wrapper.
  - `phpoffice/phpspreadsheet`: Spreadsheets processing.
  - `zircote/swagger-php`: API OpenAPI documentation.

---

## 2. Fast Command Reference

Ensure the environment is configured correctly (`.env` active with `CI_ENVIRONMENT = development`).

| Target / Workflow | Command | Purpose |
| :--- | :--- | :--- |
| **Dev Server** | `php spark serve` | Runs local PHP web server |
| **CLI / Scaffolding** | `php spark <command>` | CodeIgniter CLI entry point |
| **Test Suite** | `phpunit` or `composer test` | Executes the full PHPUnit test suite |
| **Static Analysis** | `vendor/bin/phpstan` | PHPStan static analysis (Level 5; excludes `app/Views/*`) |
| **Code Style** | `vendor/bin/php-cs-fixer fix` | Runs PHP-CS-Fixer (PSR-12, short arrays, sorted imports) |
| **Auto-Refactoring** | `vendor/bin/rector process` | Rector process (rules: Up To PHP 8.2, Code Quality, Dead Code) |

---

## 3. Architecture & Code Conventions

### Namespace Mapping (PSR-4)
- `App\` maps to `app/`
- `Config\` maps to `app/Config/`
- `Tests\Support\` maps to `tests/_support`

### Custom Core Services
Services are registered under `app/Config/Services.php` for clean dependency injection and service locators:
- `Services::twig()` → Returns `\Twig\Environment`
- `Services::imageManager()` → Returns `\Intervention\Image\ImageManager`
- `Services::redis()` → Returns `\Predis\Client`
- `Services::situacao()` → Returns `\App\Modulos\Sistema\Services\SituacaoService`
- `Services::clienteRepository()` / `Services::cliente()`
- `Services::menu()`
- `Services::empresa()`
- `Services::usuario()` / `Services::usuarioRepository()`
- `Services::plano()`

### Directory & Modular Structure
All application-specific domains must be structured inside modular directories under `app/Modulos/`.
- **Modular Scaffold Template (`app/Modulos/_Modelo/`):** When creating a new module/domain, duplicate the `_Modelo/` subdirectory. It maintains the following standard internal layers:
  - `DTO/` - Data Transfer Objects for incoming payloads.
  - `Entities/` - Domain entities mapping to database rows.
  - `Events/` - Domain events.
  - `Models/` - CodeIgniter Models.
  - `Repositories/` - Data access abstraction layer (Repositories).
  - `Rules/` - Domain business rule checkers and validators.
  - `Services/` - Module orchestration/service layer.
  - `Validators/` - Request/Payload validation logic.

---

## 4. Database Modeling & Conventions

Every database modification must follow these rules without exception.

### 4.1. Documentation-First Rule
**Before** creating or modifying any database migration, a documentation markdown file must be created or updated inside `docs/BD/{NNN}_{TABELA}.md`.
- It must document the purpose, full field dictionary, PK/UK/FK constraints, business rules, and a JSON payload example.
- The migration can only be created and run after this doc is complete.

### 4.2. Database Naming Conventions
- **Tables and Columns:** Always in **UPPERCASE** and `SNAKE_CASE` (no special characters, spaces, or accents).
- **Pluralization:** Main entities are plural (e.g., `EMPRESAS`, `CLIENTES`).
- **Pivot Tables:** Combine names of related tables in snake case (e.g., `EMPR_GRUPO_EMPRESAS`).
- **Prefixing (Domínios):** Prefix table names with a 4-letter category prefix followed by an underscore (except for base `EMPRESAS` and `CLIENTES` tables which have no prefix):
  - `EMPR_` → Complementary business tables (e.g., `EMPR_LICENCAS`, `EMPR_CONTATOS`)
  - `CLIE_` → Complementary client tables (e.g., `CLIE_ENDERECOS`)
  - `SEGU_` → Security tables (e.g., `SEGU_USUARIOS`, `SEGU_ACCOUNTS`)
  - `SIST_` → System tables (e.g., `SIST_SITUACOES`, `SIST_PLANOS`)
  - `AUDI_` → Audit tables (e.g., `AUDI_LOGS`, `AUDI_HISTORICOS`)

### 4.3. Primary Keys, Foreign Keys, & UUIDs
- **Primary Key (PK):** Must be named `ID_{ENTIDADE_SINGULAR}` (e.g., `ID_EMPRESA`, `ID_CLIENTE`). Must be `BIGINT UNSIGNED AUTO_INCREMENT` and NOT NULL.
- **Foreign Key (FK):** Must be named `{ENTIDADE_SINGULAR}_ID` (e.g., `EMPRESA_ID`, `CLIENTE_ID`). Must match PK type exactly (`BIGINT UNSIGNED`).
- **UUID:** Every main entity exposed in APIs or URLs must have a `UUID CHAR(36)` field for secure public lookup.
- **Constraints:** Use `ON DELETE RESTRICT` for relational safety on operational/financial records. **Every foreign key column must have an index.**

### 4.4. Mandatory Audit Columns
All tables (unless designated as pure pivot tables with strict exceptions) must end with the following 6 audit fields:
```sql
CRIADO_EM DATETIME NOT NULL,
ATUALIZADO_EM DATETIME NOT NULL,
EXCLUIDO_EM DATETIME NULL,
CRIADO_POR BIGINT UNSIGNED NULL, -- Foreign key referencing SEGU_USUARIOS(ID_USUARIO)
ATUALIZADO_POR BIGINT UNSIGNED NULL, -- Foreign key referencing SEGU_USUARIOS(ID_USUARIO)
EXCLUIDO_POR BIGINT UNSIGNED NULL -- Foreign key referencing SEGU_USUARIOS(ID_USUARIO)
```

### 4.5. Standardized Types (Consistency across all schemas)
- `CNPJ` → `VARCHAR(14)` (Numbers only)
- `CPF` → `VARCHAR(11)` (Numbers only)
- `E-MAIL` → `VARCHAR(255)`
- `CEP` → `VARCHAR(8)` (Numbers only)
- `UF` → `CHAR(2)` (Uppercase)
- `SENHAS / HASHES` → `VARCHAR(255)` (Bcrypt)
- `SLUGS / ROTAS` → `VARCHAR(100)` or `VARCHAR(255)` (Lowercase)
- `TELEFONES` → `VARCHAR(15)` (DDD + numbers only)

### 4.6. CodeIgniter Migrations Style
- Migrations reside in `app/Database/Migrations/`.
- Every defined field in migrations must include a `'comment'` key describing its use.

---

## 5. Testing & Validation Standards

The project uses **PHPUnit 10.5** with configuration set up in `phpunit.dist.xml` (copy to `phpunit.xml` for local adjustments).

### Database Integration Tests
- **Isolation:** By default, database tests run in-memory using **SQLite** (`:memory:`).
- **Structure:** Extend CodeIgniter's test utilities (`CIUnitTestCase` and `DatabaseTestTrait`).
- **Example Pattern (as in `tests/database/ExampleDatabaseTest.php`):**
  ```php
  use CodeIgniter\Test\CIUnitTestCase;
  use CodeIgniter\Test\DatabaseTestTrait;
  use Tests\Support\Database\Seeds\ExampleSeeder;
  use Tests\Support\Models\ExampleModel;

  final class ExampleDatabaseTest extends CIUnitTestCase
  {
      use DatabaseTestTrait;

      protected $seed = ExampleSeeder::class;

      public function testSomething(): void
      {
          $model = new ExampleModel();
          $results = $model->findAll();
          $this->assertCount(3, $results);
      }
  }
  ```

---

## 6. Rules for AI Agents

When modifying this repository, you must obey the following mandates:
1. **Never use auto-routing:** Always define routes explicitly in `app/Config/Routes.php` or through controller routing attributes.
2. **Follow the Module structure:** Put all business domain features under `app/Modulos/` following the `_Modelo` template split (DTOs, Repositories, Services, Entities).
3. **Database modifications require documentation:** Create `docs/BD/{NNN}_{TABELA}.md` before writing a migration.
4. **Adhere to the strict DB schema:** Capitalization (`UPPERCASE`), PK naming `ID_ENTITY`, FK naming `ENTITY_ID`, 6 mandatory audit fields, comments on all migration fields.
5. **Lint and Analyze:** Always run static analysis (`phpstan`) and code styling (`php-cs-fixer`) to check your work prior to indicating readiness.
