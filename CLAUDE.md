# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Gestor de Clientes PIPS** — A client and case management system for the accounting office "Méndez García & Asociados". Manages clients (clientes), case types (tipo_tramites), cases/procedures (tramites), user roles, and generates PDF receipts/reports with a full audit trail (bitácora).

## Commands

```bash
# Install dependencies
composer install
npm install

# Development
npm run dev           # Vite dev server (frontend assets)
php artisan serve     # Laravel dev server

# Production build
npm run build

# Database
php artisan migrate
php artisan migrate:fresh --seed  # Reset and seed

# Tests
./vendor/bin/pest                 # Run all tests
./vendor/bin/pest --filter=...    # Run specific test

# Code style
./vendor/bin/pint                 # Fix code style (Laravel Pint)
```

On fresh install, `composer install` auto-generates `.env` from `.env.example`, creates the SQLite database, and runs migrations.

## Architecture

**Stack:** Laravel 11 + Livewire 3 + Volt + Tailwind CSS + SQLite (default) + DomPDF

### Routing & Controllers

All routes in [`routes/web.php`](routes/web.php) require authentication. There are only two traditional controllers:
- `DashboardController` — aggregates Chart.js data (client/case trends)
- `PDFController` — generates receipts (`/tramites/pdf/{id}`) and reports (`/reportes/pdf/{tipo}`)

Everything else is handled by **Livewire components**.

### Livewire Components (`app/Livewire/`)

Each resource has a dedicated Livewire class paired with a Blade view in `resources/views/livewire/`. Components handle CRUD, search/filter, and pagination inline (no separate API layer):

| Component | Resource |
|-----------|----------|
| `Clientes` | Client management |
| `Tramites` | Case/procedure management |
| `TipoClientes` | Client type categories |
| `TipoTramites` | Case type categories |
| `Usuarios` | User management |
| `Roles` | Role management |
| `Bitacora` | Audit log viewer (read-only) |
| `Reportes` | Report generation UI |

### Core Models & Relationships

```
User (role_id) → Role
Cliente (tipo_cliente_id, user_id) → TipoCliente, User
  └── hasMany: Tramite
  └── hasOne: AgenciaVirtual
Tramite (cliente_id, tipo_tramite_id, user_id) → Cliente, TipoTramite, User
Bitacora (user_id) → User
```

**Tramite** is the central entity: tracks `fecha`, `estado`, `precio`, `gastos`, `observaciones`, and links a client to a case type.

### Audit Logging

Model Observers in `app/Observers/` automatically write to the `bitacoras` table on create/delete events. The `tipo` column is an enum: `creacion`, `eliminacion`, `reporte`.

### PDF Generation

`PDFController` uses `barryvdh/laravel-dompdf`. Templates are in `resources/views/pdf/`. Reports support weekly, monthly, and date-range filtering.

### Frontend

- **Toastr** (`yoeunes/toastr`) for flash notifications
- **Chart.js** loaded in dashboard view for trend charts
- Tailwind config in [`tailwind.config.js`](tailwind.config.js) with content paths for Livewire views

## Database

SQLite by default (`.env` `DB_CONNECTION=sqlite`). Session, cache, and queue all use the `database` driver. To switch to MySQL, update `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env`.

Key table constraints: `clientes.dpi` and `clientes.nit` are unique; `tramites` enforces FK on `cliente_id`, `tipo_tramite_id`, and `user_id` with cascade deletes.

## HTTPS Enforcement

Production forces HTTPS via `AppServiceProvider` (`URL::forceScheme('https')` behind an environment check). See the most recent commit for context.
