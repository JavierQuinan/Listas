# Billing & Inventory System — Angular + PHP

> **Portfolio evidence:** Angular 18 frontend · PHP MVC-style backend · SQLite · authentication hardening · reproducible database bootstrap · automated quality checks.
>
> This repository is presented as an academic full-stack engineering artifact, not as production-ready enterprise software.

## What is implemented

The repository contains a working multi-part billing/inventory codebase with:

- Angular 18 frontend code;
- PHP MVC-style backend;
- SQLite persistence through PDO;
- CRUD/domain controllers for clients, invoices, VAT, products, suppliers, units of measure and users;
- schema and synthetic seed data;
- reproducible SQLite initialization;
- PDF/reporting utilities;
- authentication with hashed passwords;
- configurable CORS allowlist;
- automated authentication smoke checks;
- GitHub Actions quality workflow;
- Angular production-build verification in CI.

## Architecture

```text
Proyectos/
├── 03MVC/
│   ├── config/
│   │   ├── config.php        # PDO / SQLite connection
│   │   └── http.php          # JSON + CORS policy
│   ├── controllers/
│   ├── models/
│   ├── database/
│   │   ├── schema.sql
│   │   ├── seed.sql
│   │   ├── init_db.php
│   │   └── create_local_admin.php
│   └── tests/
│       └── auth_smoke.php
└── 04Plantilla/
    └── Angular 18 administration frontend
```

The generated `facturacion.db` file is not versioned. It is recreated from `schema.sql` and `seed.sql`.

## Security controls present

The current source includes these concrete controls:

- `password_hash()` for password storage;
- `password_verify()` for login validation;
- password hashes excluded from user list/detail/login responses;
- invalid login returns HTTP `401`;
- minimum password validation in the user controller;
- `Usuarios.Nombre_Usuario` is unique in the generated SQLite schema;
- no known/default administrator password is stored in `seed.sql`;
- local administrator creation requires `DEMO_ADMIN_PASSWORD` from the environment;
- wildcard CORS is not used;
- allowed origins are centralized in `config/http.php` and configured with `APP_ALLOWED_ORIGINS`;
- generated database files remain outside version control.

### Local administrator bootstrap

After initializing the database, create a local administrator without committing credentials:

```bash
cd Proyectos/03MVC/database
php init_db.php
DEMO_ADMIN_PASSWORD='choose-a-local-password-at-least-12-chars' php create_local_admin.php
```

Optional username:

```bash
DEMO_ADMIN_USERNAME='local-admin' \
DEMO_ADMIN_PASSWORD='choose-a-local-password-at-least-12-chars' \
php create_local_admin.php
```

## Reproducible authentication checks

The repository contains `Proyectos/03MVC/tests/auth_smoke.php`.

With a local administrator already created:

```bash
cd Proyectos/03MVC
DEMO_ADMIN_USERNAME='local-admin' \
DEMO_ADMIN_PASSWORD='choose-a-local-password-at-least-12-chars' \
php tests/auth_smoke.php
```

The smoke test checks that:

1. valid credentials authenticate;
2. invalid credentials are rejected;
3. login output does not expose the stored hash;
4. user list/detail responses do not expose the stored hash;
5. the stored password is not plaintext;
6. the stored hash validates through `password_verify()`.

## Automated quality workflow

`.github/workflows/portfolio-quality.yml` defines two independent CI jobs:

### PHP / SQLite security baseline

- verifies PHP + SQLite support;
- syntax-checks PHP source files;
- recreates the SQLite database from versioned schema/seed files;
- creates an ephemeral CI administrator through environment variables;
- executes the authentication smoke test;
- removes the generated database after the check.

### Angular 18 build

```bash
cd Proyectos/04Plantilla
npm ci
npm run build -- --configuration production
```

The workflow uses read-only repository permissions (`contents: read`).

## Functional domains represented

The PHP layer includes code for:

- clients;
- invoices;
- VAT;
- products;
- suppliers;
- units of measure;
- users/authentication.

The Angular application provides the administrative UI used by the academic billing/inventory workflow.

## Third-party attribution

The Angular admin frontend under `Proyectos/04Plantilla` is based on the **Mantis Free Angular Admin Template** by **CodedThemes** and retains its MIT-license metadata.

The template foundation is third-party work. Repository-specific business/domain changes are therefore not represented as an entirely original UI framework.

The repository also contains third-party libraries such as FPDF; their original copyright/license conditions remain applicable.

## Current technical boundary

The repository demonstrates authentication, CRUD/domain code, database initialization and frontend integration, but it does **not** claim:

- production deployment or production security audit;
- complete authorization/RBAC enforcement on every backend operation;
- a uniform enterprise-grade API error contract across all historical controllers;
- CSRF protection for a cookie-session architecture (the current evidence does not present such an architecture);
- complete integration-test coverage for every CRUD domain;
- that the Mantis UI foundation is original work.

These are boundaries of the current artifact, not advertised future features.

## Portfolio classification

**Category:** Angular + PHP full-stack academic evidence  
**Classification:** `PORTFOLIO EVIDENCE`  
**Role:** supporting full-stack evidence

The repository is intentionally documented around verifiable source and reproducible checks rather than inflated completeness claims.

See the main [GitHub profile](https://github.com/JavierQuinan) and [Portfolio Governance](https://github.com/JavierQuinan/JavierQuinan/blob/main/docs/PORTFOLIO_GOVERNANCE.md).

## Resumen en español

Proyecto académico full stack con **Angular 18 + PHP + SQLite**, que demuestra CRUD de clientes/productos/proveedores/facturación, autenticación con `password_hash/password_verify`, CORS por allowlist, inicialización reproducible de SQLite, creación segura de usuario local mediante variables de entorno y smoke tests de autenticación. La interfaz administrativa utiliza como base Mantis Free Angular Admin Template de CodedThemes y mantiene su atribución.

## License

This repository includes MIT-licensed material. Third-party components retain their respective licenses and attribution requirements.
