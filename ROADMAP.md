# Billing & Inventory — Product & Engineering Roadmap

This roadmap preserves the long-term evolution of the Angular + PHP billing/inventory project while keeping future ideas separate from current portfolio evidence.

## Status legend

- ✅ **Implemented / evidenced** — present in source and/or verified by the repository quality gate.
- 🔄 **Priority engineering direction** — sensible next work for the current architecture.
- 🧭 **Strategic evolution** — possible future capability; not a current claim or delivery commitment.

The current source of truth remains [`README.md`](./README.md).

## 1. Current verified baseline

- ✅ Angular 18 administration frontend.
- ✅ PHP MVC-style backend.
- ✅ SQLite persistence through PDO.
- ✅ CRUD/domain code for clients, invoices, VAT, products, suppliers, units of measure and users.
- ✅ reproducible database initialization from versioned schema/seed files.
- ✅ generated database excluded from version control.
- ✅ password storage with `password_hash()`.
- ✅ authentication through `password_verify()`.
- ✅ password hashes excluded from authentication/user responses.
- ✅ environment-driven local administrator bootstrap; no known administrator password committed in the seed.
- ✅ configurable CORS allowlist instead of wildcard CORS.
- ✅ authentication smoke tests.
- ✅ GitHub Actions quality gate for PHP/SQLite/authentication plus Angular production build.

## 2. Security and authorization maturity

- 🔄 define and test role/permission rules for administrative operations.
- 🔄 centralize authorization checks instead of relying on individual controller conventions.
- 🔄 add negative-path tests for unauthorized CRUD actions.
- 🔄 review request validation and output encoding across historical controllers.
- 🔄 formalize authentication/session architecture if the application evolves beyond the current local evidence flow.
- 🧭 CSRF protection if cookie-based authenticated browser mutations are introduced.
- 🧭 security headers and deployment-specific HTTPS policy for a hosted version.
- 🧭 dependency/secret scanning appropriate to PHP and Angular components.
- 🧭 lightweight threat model for users, invoices and administrative operations.

## 3. Backend/API evolution

- 🔄 standardize JSON success/error envelopes across backend controllers.
- 🔄 centralize input validation for shared fields and domain constraints.
- 🔄 increase automated tests for client/product/supplier/invoice CRUD behavior.
- 🧭 versioned REST API boundary if the frontend/backend become independently deployable.
- 🧭 OpenAPI documentation after a stable HTTP contract exists.
- 🧭 service/application layer for invoice operations when business rules become complex enough to justify it.

## 4. Data and billing domain maturity

Potential evolution of the existing domain:

- 🔄 stricter referential/domain validation for invoice lines, taxes and inventory quantities.
- 🔄 deterministic invoice-total/tax tests.
- 🧭 inventory movements and stock ledger.
- 🧭 purchase/receiving flows.
- 🧭 configurable tax/rate catalog.
- 🧭 credit-note / cancellation lifecycle.
- 🧭 customer account/history views.
- 🧭 audit-friendly transaction history.
- 🧭 multi-branch support if backed by a clear tenancy/authorization model.

These are roadmap ideas until source and tests exist.

## 5. Angular frontend maturity

The current Angular UI uses the Mantis Free Angular Admin Template foundation with proper attribution.

- 🔄 improve typed service/error boundaries between UI and backend.
- 🔄 consistent loading, empty, success and failure states.
- 🔄 form validation aligned with backend rules.
- 🔄 responsive/accessibility review.
- 🧭 component tests for representative business forms.
- 🧭 E2E smoke flow for login → product/client → invoice using synthetic data.
- 🧭 dashboard/reporting improvements backed by real domain queries.

## 6. Persistence evolution

SQLite is appropriate for the current reproducible academic evidence baseline.

- 🔄 maintain deterministic schema/seed migrations.
- 🧭 PostgreSQL or MySQL only if concurrent hosted use or operational requirements justify it.
- 🧭 migration/backup strategy before any persistent deployment claim.
- 🧭 synthetic demo datasets for repeatable portfolio scenarios.

## 7. Quality engineering

- 🔄 extend the PHP smoke baseline into domain-level automated tests.
- 🔄 add Angular lint/test checks only when the corresponding project configuration is verified and stable.
- 🧭 browser E2E for a representative billing workflow.
- 🧭 coverage reporting as an engineering diagnostic, not a vanity target.
- 🧭 release/build artifact validation if public releases are introduced.

## 8. Product/portfolio evolution

- 🧭 sanitized screenshots of representative workflows.
- 🧭 architecture diagram based on the actual deployed/versioned design.
- 🧭 CHANGELOG/releases if the project begins versioned delivery.
- 🧭 hosted synthetic demo only after security, authorization and data-reset strategy are suitable for public access.

## Promotion rule

A roadmap item moves to ✅ only when implementation is versioned, relevant verification exists, documentation reflects the actual state and the quality gate remains green.
