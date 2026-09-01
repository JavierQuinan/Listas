# Sistema de Facturación e Inventario — Angular + PHP

> **Repository status:** hardening candidate / academic engineering evidence. The repository contains substantial working code, but it is **not yet presented as production-ready portfolio software**.

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

The Angular admin frontend under `Proyectos/04Plantilla` is based on the **Mantis Free Angular Admin Template** by **CodedThemes** and retains its MIT license metadata. The template foundation is third-party work; repository-specific application/domain changes must not be represented as an entirely original UI framework.

## Architecture snapshot

```text
Proyectos/
├── 03MVC/
│   ├── config/
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

## Security status

This repository is **not ready for promotion to first-line portfolio evidence** because the current authentication implementation stores and compares passwords as plain text, and controller-level CORS is permissive (`*`). The seed also includes a development-only default user credential.

Before promotion, the project should at minimum:

1. migrate password storage to `password_hash()` / `password_verify()`
2. invalidate the plaintext seed credential pattern
3. restrict CORS by environment
4. add explicit authorization/role enforcement
5. add automated backend and integration tests
6. verify Angular tests/build from a clean checkout
7. review all API error handling and input validation
8. document third-party template customization boundaries

## Portfolio classification

**Category:** Angular + PHP full-stack academic evidence  
**Current classification:** HARDENING CANDIDATE  
**Portfolio priority:** Medium after remediation  
**Pinned repository:** No, until the hardening gate is satisfied

This repository is intentionally documented with its limitations rather than overstating completeness or production readiness.

See the main [GitHub profile](https://github.com/JavierQuinan) and [Portfolio Governance](https://github.com/JavierQuinan/JavierQuinan/blob/main/docs/PORTFOLIO_GOVERNANCE.md).

## License

The repository includes MIT-licensed material. Third-party components retain their respective licenses and attribution requirements.
