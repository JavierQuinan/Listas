# Changelog

Todos los cambios notables de este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/lang/es/).

## [1.0.0] - 2026-01-02

### Agregado
- Sistema completo de facturación con Angular 18 y PHP 8
- Migración de MySQL a SQLite para portabilidad
- Módulos: Clientes, Productos, Proveedores, Facturas, Kardex
- Sistema de autenticación de usuarios
- Dashboard administrativo con ApexCharts
- Generación de reportes PDF con FPDF
- Scripts de inicio rápido (iniciar.bat, iniciar.ps1)
- Documentación completa en README.md
- Guías de contribución (CONTRIBUTING.md)
- Código de conducta (CODE_OF_CONDUCT.md)

### Cambiado
- Backend migrado de mysqli a PDO con prepared statements
- URLs de API centralizadas en environment.ts
- Arquitectura MVC mejorada con controladores PDO

### Seguridad
- Implementación de prepared statements para prevenir SQL injection
- Validación de parámetros en todos los controladores

## [0.1.0] - 2024-07-15

### Agregado
- Estructura inicial del proyecto
- Configuración básica de Angular y PHP
- Módulos básicos de CRUD

---

[1.0.0]: https://github.com/JavierQuinan/Listas/releases/tag/v1.0.0
[0.1.0]: https://github.com/JavierQuinan/Listas/releases/tag/v0.1.0
