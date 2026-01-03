# Guía de Contribución

Gracias por tu interés en contribuir a este proyecto. Esta guía te ayudará a hacerlo de manera efectiva.

## Código de Conducta

Al participar en este proyecto, aceptas cumplir con nuestro [Código de Conducta](CODE_OF_CONDUCT.md).

## Cómo Contribuir

### Reportar Bugs

1. Verifica que el bug no haya sido reportado previamente en [Issues](../../issues)
2. Crea un nuevo issue usando la plantilla de bug report
3. Incluye pasos detallados para reproducir el problema
4. Agrega capturas de pantalla si es relevante

### Proponer Mejoras

1. Abre un issue describiendo la mejora propuesta
2. Espera feedback antes de comenzar a implementar
3. Referencia el issue en tu PR

### Pull Requests

1. Fork el repositorio
2. Crea una rama desde `main` siguiendo las convenciones de naming
3. Realiza tus cambios
4. Asegúrate de que el código funciona correctamente
5. Crea el PR con una descripción clara

## Convenciones

### Naming de Branches

```
<tipo>/<descripcion-corta>
```

| Tipo | Uso |
|------|-----|
| `feature/` | Nueva funcionalidad |
| `fix/` | Corrección de bugs |
| `docs/` | Documentación |
| `refactor/` | Refactorización de código |
| `chore/` | Tareas de mantenimiento |
| `test/` | Agregar o modificar tests |

**Ejemplos:**
- `feature/add-export-pdf`
- `fix/login-validation`
- `docs/api-documentation`

### Mensajes de Commit

Usamos [Conventional Commits](https://www.conventionalcommits.org/):

```
<tipo>(<scope>): <descripción>

[cuerpo opcional]

[footer opcional]
```

**Tipos permitidos:**
- `feat`: Nueva funcionalidad
- `fix`: Corrección de bug
- `docs`: Cambios en documentación
- `style`: Formato (sin cambios de código)
- `refactor`: Refactorización
- `test`: Agregar o corregir tests
- `chore`: Mantenimiento

**Ejemplos:**
```
feat(productos): add barcode scanner support
fix(auth): resolve session timeout issue
docs(readme): update installation steps
```

### Estilo de Código

#### PHP
- PSR-12 coding standard
- Documentar funciones con PHPDoc

#### Angular/TypeScript
- Seguir Angular Style Guide
- Usar tipos estrictos

## Entorno de Desarrollo

```bash
# Backend PHP
cd Proyectos/03MVC
php -S localhost:8000

# Frontend Angular
cd Proyectos/04Plantilla
pnpm install
pnpm start
```

## Preguntas

Si tienes dudas, abre un issue con la etiqueta `question`.

---

Gracias por contribuir.
