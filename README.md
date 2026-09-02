# Sistema de Facturación e Inventario — Angular + PHP

> **Repository status:** portfolio evidence / academic full-stack system. The repository demonstrates real Angular + PHP + SQLite implementation and has completed its first security-hardening gate. It is **not presented as production-ready enterprise software**.

## Verified engineering scope

The repository contains a multi-part academic system with:

- Angular 18 frontend code
- PHP MVC-style backend
- SQLite persistence
- controllers for clients, invoices, VAT, products, suppliers, units of measure and users
- schema + seed scripts
- reproducible SQLite initialization through `Proyectos/03MVC/database/init_db.php`
- frontend dependencies for Bootstrap, ApexCharts, PDF generation and related UI functionality

## Important attribution

The Angular admin frontend under `Proyectos/04Plantilla` is based on the **Mantis Free Angular Admin Template** by **CodedThemes** and retains its MIT license metadata. The template foundation is third-party work; repository-specific application/domain changes are not represented as an entirely original UI framework.

## Architecture snapshot

```text
Proyectos/
├── 03MVC/
│   ├── config/
│   │   ├── config.php
│   │   └── http.php
│   ├── controllers/
│   ├── models/
│   ├── database/
│   │   ├── schema.sql
│   │   ├── seed.sql
│   │   └── init_db.php
│   └── tienda/
└── 04Plantilla/
    └── Angular 18 admin frontend (Mantis/CodedThemes base)
```

The generated `facturacion.db` file is intentionally not versioned. The database is recreated from `schema.sql` and `seed.sql`:

```bash
cd Proyectos/03MVC/database
php init_db.php
```

## Verified backend domains

The current PHP controller layer includes:

- clients
- invoices
- VAT
- products
- suppliers
- units of measure
- users

These controllers are evidence of CRUD/domain implementation, not a claim of a hardened enterprise API.

## Security hardening completed

The first blocking security findings have been remediated:

- user passwords are hashed with `password_hash()` and verified with `password_verify()`
- user list/detail/login responses do not expose the stored password hash
- the development admin seed stores a bcrypt hash instead of a plaintext password
- login rejects invalid credentials with HTTP 401
- minimum password validation is applied by the user controller
- wildcard CORS headers were removed from all seven PHP controllers
- CORS is centralized in `config/http.php`
- allowed origins are configurable through `APP_ALLOWED_ORIGINS`, with local-development defaults only

## Remaining engineering debt

Promotion to `PORTFOLIO EVIDENCE` does not mean production readiness. The next hardening gate should include:

1. automated PHP/integration tests for auth and CRUD flows
2. Angular build/test verification in CI
3. explicit session/token authorization rather than treating authentication alone as authorization
4. role/permission enforcement per operation
5. stronger request validation and consistent HTTP status/error contracts
6. CSRF/session review if browser-cookie authentication is introduced
7. dependency and template-license review from a clean checkout

## Portfolio classification

**Category:** Angular + PHP full-stack academic evidence  
**Current classification:** PORTFOLIO EVIDENCE  
**Portfolio priority:** Supporting evidence  
**Pinned repository:** Not currently; stronger SaaS/AI repositories remain first-line

This repository is intentionally documented with its limitations rather than overstating completeness or production readiness.

See the main [GitHub profile](https://github.com/JavierQuinan) and [Portfolio Governance](https://github.com/JavierQuinan/JavierQuinan/blob/main/docs/PORTFOLIO_GOVERNANCE.md).

## License

The repository includes MIT-licensed material. Third-party components retain their respective licenses and attribution requirements.
