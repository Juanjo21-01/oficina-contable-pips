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
php artisan migrate:fresh --seed  # Reset and seed (creates Administrador/Empleado roles + admin user)

# Tests
./vendor/bin/pest                 # Run all tests
./vendor/bin/pest --filter=...    # Run specific test

# Code style
./vendor/bin/pint                 # Fix code style (Laravel Pint)
```

On fresh install, `composer install` auto-generates `.env` from `.env.example`, creates the SQLite database, and runs migrations.

## Architecture

**Stack:** Laravel 11 + Livewire 3 + Volt + Tailwind CSS + SQLite (default) + DomPDF + Laravel Breeze (auth scaffolding)

### Routing & Controllers

All routes in [`routes/web.php`](routes/web.php) require authentication. There are only two traditional controllers:
- `DashboardController` — aggregates Chart.js data (client/case trends, current-month financials)
- `PDFController` — generates receipts (`/tramites/pdf/{id}`) and reports (`/reportes/pdf/{tipo}`)

Everything else uses view-based routing resolved by **Livewire/Volt components**.

### Livewire Component Pattern

Each resource module follows a consistent four-component structure:

```
app/Livewire/{Module}/
  Tabla.php      — list view with search, filtering by estado, pagination, inline edit/delete
  Formulario.php — create/edit form
  Detalle.php    — read-only detail view
  Modal.php      — modal wrapper
```

Modules: `Clientes`, `Tramites`, `TipoClientes`, `TipoTramites`, `Usuarios`, `Bitacora`, `Reportes`, `Roles`

**Exceptions:**
- `Bitacora` — no Formulario (read-only audit log)
- `Reportes/Tabla.php` — handles semana/mes/rango filtering with optional cliente and tipo_tramite filters
- `Roles/TarjetaUsuarios.php` — additional component showing users grouped by role

### Core Models & Relationships

```
Role
  └── hasMany: User (role_id) — only two roles: "Administrador", "Empleado"

User (role_id, estado)
  ├── hasMany: Cliente
  ├── hasMany: Tramite
  └── hasMany: Bitacora

TipoCliente
  └── hasMany: Cliente

Cliente (tipo_cliente_id, user_id, estado)  — unique: dpi, nit, email
  ├── hasMany: Tramite
  └── hasOne: AgenciaVirtual  — uses cliente_id as PK (not a separate id column)

TipoTramite
  └── hasMany: Tramite

Tramite (cliente_id, tipo_tramite_id, user_id, estado)
  — tracks: fecha, precio (decimal), gastos (decimal), observaciones

Bitacora (user_id)
  — tipo enum: creacion | eliminacion | reporte
```

`AgenciaVirtual` stores virtual-office credentials (correo, password, observaciones) for a client — its primary key is `cliente_id` (unique per client, not auto-increment).

### Audit Logging

Model Observers in `app/Observers/` fire **only on `created` and `deleted`** (not `updated`). Registered in `AppServiceProvider`. The `Reportes` PDF generation also writes a `reporte` entry to `bitacoras`.

### PDF Generation

`PDFController` uses `barryvdh/laravel-dompdf`. Templates in `resources/views/pdf/`. Reports support weekly, monthly, and date-range filtering with optional cliente/tipo_tramite filters; they calculate totalTramites, totalPrecio, totalGastos, gastoTotal, promedioGasto.

### Frontend

- **Tailwind** with custom design tokens in [`tailwind.config.js`](tailwind.config.js):
  - `brand` — primary teal palette (50–900)
  - `surface` — card background variants (DEFAULT, muted, dark, dark-muted)
  - `action` — semantic button colors: `view` (purple), `edit` (orange), `delete` (rose), `add` (brand-teal)
  - `status` — `active` (brand), `inactive` (rose), `pending` (amber), `info` (blue)
  - Custom border-radius (`card`, `badge`, `button`) and box-shadow (`card`, `card-hover`) tokens
- **Toastr** (`yoeunes/toastr`) for flash notifications
- **Chart.js** loaded in dashboard view for 6-month trend charts

## Database

SQLite by default. Session, cache, and queue all use the `database` driver. Key constraints: `clientes.dpi`, `clientes.nit`, and `clientes.email` are unique; `tramites` enforces FKs with cascade deletes.

## HTTPS Enforcement

Production forces HTTPS via `AppServiceProvider` (`URL::forceScheme('https')` behind an environment check).
