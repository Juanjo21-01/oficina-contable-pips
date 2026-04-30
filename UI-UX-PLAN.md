# UI/UX Refactor Plan — Gestor de Clientes PIPS

> Objetivo: rehacer la interfaz completa con estructura elegante, paleta profesional, dark mode funcional y un sistema de componentes reutilizable basado en **Flux UI Free + Tailwind**.

---

## Contexto

**Estado actual**
- Laravel 11 + Livewire 3 + Volt + Tailwind 3.1 + Alpine
- Tokens custom ya definidos (`brand` teal, `surface`, `action`, `status`)
- Componentes Blade legacy de Breeze (`primary-button`, `text-input`, `modal`, etc.) mezclados con nuevos (`data-table`, `breadcrumb`, `empty-state`, `status-badge`, `action-buttons`)
- Sidebar + header ya funcionales, con submenús Alpine
- Dark mode implementado pero **defectuoso**: FOUC al cargar + estado Alpine se pierde con `wire:navigate` en algunos casos
- Logo en `/public/img/logo.png` (raster, no SVG)
- Toastr como notificaciones
- CSS con animación residual de hamster en login — eliminar

**Decisiones tomadas**
1. **Flux UI Free** como librería base
2. Paleta **Indigo primary + Teal accent**
3. Dark mode **arreglar** (no eliminar)
4. **Módulo piloto: Clientes** antes de propagar
5. Logo PNG → mantener por ahora, optimizar a SVG en fase posterior (no bloqueante)

---

## Sistema de diseño

### Paleta

```
Primary (Indigo)     — brand institucional, CTA, headers activos
  50:  #eef2ff    500: #6366f1    900: #312e81
  100: #e0e7ff    600: #4f46e5    950: #1e1b4b
  200: #c7d2fe    700: #4338ca
  300: #a5b4fc    800: #3730a3

Accent (Teal — `brand` actual)  — highlights, charts, selected tab, marca secundaria
  (mantener tokens existentes: #14b8a6 → #115e59)

Neutrales (Slate)    — reemplaza `gray` custom actual
  50:  #f8fafc    500: #64748b    900: #0f172a
  100: #f1f5f9    600: #475569    950: #020617
  200: #e2e8f0    700: #334155
  300: #cbd5e1    800: #1e293b
  400: #94a3b8

Semánticos
  success: emerald-500 (#10b981)   — estado activo, pagos recibidos
  warning: amber-500  (#f59e0b)    — pendientes, plazos próximos
  danger:  rose-500   (#f43f5e)    — eliminar, errores, estado inactivo
  info:    sky-500    (#0ea5e9)    — notificaciones, tips
```

**Rol por color**

| Elemento | Color |
|---------|-------|
| Botón primario, link principal, header activo, focus ring | `primary-600` |
| Botón secundario, bordes, divisores | `slate-200` / `slate-700` dark |
| Texto principal | `slate-900` / `slate-100` dark |
| Texto secundario | `slate-600` / `slate-400` dark |
| Texto sutil (placeholder, helper) | `slate-400` / `slate-500` dark |
| Fondo página | `slate-50` / `slate-950` dark |
| Fondo superficie (card) | `white` / `slate-900` dark |
| Accent (charts, selected tab, brand visual) | `brand-500` (teal) |

### Tipografía

```
Sans body       → Inter variable
Sans display    → Plus Jakarta Sans variable (títulos, headers)
Mono numérico   → JetBrains Mono variable (precios, DPI/NIT, montos PDF)
```

Self-host vía `@fontsource-variable` (npm) — mejor performance que Google Fonts CDN. Fallback: system stack.

**Escala**

```
text-xs   12px → labels menores, badges
text-sm   14px → body tablas, form helpers
text-base 16px → body default
text-lg   18px → subtítulos card
text-xl   20px → section-title
text-2xl  24px → page-title mobile
text-3xl  30px → page-title desktop, KPI numbers
text-4xl  36px → dashboard KPI grande
```

Line-height: `leading-relaxed` (1.625) body; `leading-tight` (1.25) títulos. Tabular nums: `font-variant-numeric: tabular-nums` en `<td>` numéricos y KPIs.

### Espaciado, radios, sombras

```
Spacing base: 4 / 8 / 12 / 16 / 24 / 32 / 48 / 64 px (ritmo 4-8pt)
Radio: rounded-md (6) botones / rounded-lg (8) cards, inputs / rounded-xl (12) modales / rounded-full badges, avatars
Sombra: shadow-sm default / shadow-md hover / shadow-lg overlay (dropdown, popover)
Modal scrim: bg-slate-900/60 backdrop-blur-sm
```

Eliminar `shadow-card-hover` con `scale-[1.01]` — genera jitter y layout shift.

### Iconos

- **`blade-ui-kit/blade-heroicons`** — Heroicons oficial, `solid` + `outline`, size con clases Tailwind
- Un solo set, stroke width 1.5 para outline
- Eliminar SVGs inline en navegación y tablas → `<x-heroicon-o-home class="w-5 h-5" />`

---

## Dark mode: fix definitivo

### Problemas actuales

1. **FOUC**: script de tema lee `localStorage` **después** que body pinta → flash claro en dark mode
2. **Estado Alpine perdido**: `wire:navigate` preserva DOM pero reinicia algunos `x-data` scopes; submenús se cierran al navegar
3. **`darkMode` acoplado a `data()` global** del layout → difícil mantener y probar

### Solución

**A — Pre-paint script** (elimina FOUC)

En `<head>` antes de `@vite`, script inline bloqueante:

```html
<script>
  (function () {
    const stored = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = stored ? stored === 'dark' : prefersDark;
    if (isDark) document.documentElement.classList.add('dark');
  })();
</script>
```

**B — Alpine.store para tema** (persistente entre `wire:navigate`)

En `resources/js/app.js`:

```js
document.addEventListener('alpine:init', () => {
  Alpine.store('theme', {
    isDark: document.documentElement.classList.contains('dark'),
    toggle() {
      this.isDark = !this.isDark;
      document.documentElement.classList.toggle('dark', this.isDark);
      localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
    },
  });
});
```

En header:
```html
<button @click="$store.theme.toggle()" :aria-label="$store.theme.isDark ? 'Modo claro' : 'Modo oscuro'">
  <template x-if="!$store.theme.isDark"><!-- sol --></template>
  <template x-if="$store.theme.isDark"><!-- luna --></template>
</button>
```

**C — Submenús con estado derivado de ruta**

El sidebar actual ya calcula `$usersActive`, `$tramitesActive`, `$clientesActive`. Usar estos en `x-data="{ open: {{ $xActive ? 'true' : 'false' }} }"` pero añadir `@persist('sidebar')` (Livewire v3) alrededor del `<aside>` para mantener DOM y estado entre `wire:navigate`. Si `@persist` no resuelve, fallback: derivar 100% estado abierto de la ruta activa (sin Alpine state local), abre al navegar.

**D — Integridad morph Livewire**

`wire:navigate` usa morphdom. Verificar que componentes Alpine declaran `x-data` con objeto literal estable; no llamar `data()` si no existe ya en el nuevo DOM. Quitar el `x-data="data()"` gigante del `<html>`; reemplazar con stores + componentes pequeños `x-data="{ isSideMenuOpen: false }"` en los nodos que lo necesitan.

### Checklist dark mode post-fix
- [ ] Sin FOUC al refrescar con tema oscuro
- [ ] Toggle mantiene estado tras `wire:navigate`
- [ ] Submenús sidebar no se cierran al navegar
- [ ] Contraste ≥ 4.5:1 texto principal en ambos temas
- [ ] Bordes visibles en ambos temas
- [ ] Toast / flash adapta

---

## Librerías a instalar

| Paquete | Razón |
|---------|-------|
| `livewire/flux` | Componentes oficiales Livewire (gratis tier): button, input, select, modal, dropdown, toast, badge, card, table |
| `blade-ui-kit/blade-heroicons` | Iconos SVG consistentes vía Blade |
| `@fontsource-variable/inter` | Self-host Inter |
| `@fontsource-variable/plus-jakarta-sans` | Self-host Jakarta |
| `@fontsource-variable/jetbrains-mono` | Self-host JetBrains Mono |

**Comandos**
```bash
composer require livewire/flux blade-ui-kit/blade-heroicons
npm install @fontsource-variable/inter @fontsource-variable/plus-jakarta-sans @fontsource-variable/jetbrains-mono
php artisan flux:activate   # publica assets Flux (free tier, sin licencia)
```

---

## Auditoría de componentes actuales

### Mantener tal cual (ajustes menores)
- `breadcrumb.blade.php` — OK, actualizar tokens
- `empty-state.blade.php` — OK, añadir variante `icon` prop
- `data-table.blade.php` — base sólida; envolver tabla Flux
- `status-badge.blade.php` — adaptar tokens semánticos
- `action-buttons.blade.php` — reemplazar SVGs por Heroicons

### Refactor / reemplazar por Flux

| Legacy | Nuevo |
|--------|-------|
| `primary-button.blade.php` | `<flux:button variant="primary">` |
| `secondary-button.blade.php` | `<flux:button variant="outline">` |
| `danger-button.blade.php` | `<flux:button variant="danger">` |
| `text-input.blade.php` | `<flux:input>` |
| `input-label.blade.php` | integrado en `<flux:field>` |
| `input-error.blade.php` | integrado en `<flux:error>` |
| `modal.blade.php` | `<flux:modal>` |
| `dropdown.blade.php` | `<flux:dropdown>` |
| `dropdown-link.blade.php` | `<flux:dropdown.item>` |
| `nav-link.blade.php` | `<flux:navlist.item>` o custom sidebar |
| `responsive-nav-link.blade.php` | igual |
| `application-logo.blade.php` | `<x-ui.logo>` nuevo |
| `action-message.blade.php` | Flux toast |
| `auth-session-status.blade.php` | mantener pero restilear |

### Nuevos a crear

```
resources/views/components/ui/
  logo.blade.php         — wrapper logo, soporta size + dark variant
  page-header.blade.php  — title + description + actions slot
  stat-card.blade.php    — KPI dashboard (icon + label + value + trend)
  form-field.blade.php   — label + flux:input + error + helper (si Flux no cubre bien)
  date-range-picker.blade.php  — para reportes
  toast-host.blade.php   — notificaciones (reemplaza Toastr)
  section.blade.php      — card con header / body / footer slots
  kbd.blade.php          — atajos teclado
```

### Eliminar
- CSS `.wheel-and-hamster` y keyframes (líneas 149-489 de `resources/css/app.css`) — peso muerto
- Toastr: `yoeunes/toastr` → reemplazar por Flux toast o componente Alpine custom
- `x-data="data()"` gigante en `<html>` del layout → dividir en stores + micro-componentes

---

## Plan de fases

### Fase 0 — Foundation (1-2 días)

**Tareas**
1. Instalar Flux + Heroicons + fonts (comandos arriba)
2. `php artisan flux:activate`
3. Actualizar `tailwind.config.js`:
   - Añadir paleta `primary` (indigo)
   - Reemplazar `gray` custom por `slate`
   - Añadir `fontFamily.display` (Jakarta) y `fontFamily.mono` (JetBrains)
   - Añadir `content` paths de Flux: `./vendor/livewire/flux/stubs/**/*.blade.php`
   - Mantener `brand` (teal) como accent
4. Actualizar `resources/css/app.css`:
   - Import `@fontsource-variable/*`
   - Eliminar hamster CSS
   - Reescribir `@layer components` con tokens nuevos (primary para CTAs, brand solo para accent)
   - Mantener utilidades útiles (`.card`, `.badge-*`, `.table-*`) con nuevos tokens
5. Pre-paint theme script en `<head>` del layout
6. Alpine store `theme` en `resources/js/app.js`
7. Reemplazar toggle actual del header por `$store.theme`

**Criterio éxito**
- `npm run build` sin errores
- Login + dashboard cargan con fuentes nuevas, paleta nueva
- Dark mode sin FOUC, persiste entre navegaciones

### Fase 1 — Layout shell (1 día)

**Tareas**
1. Refactor `layouts/app.blade.php`:
   - Eliminar `data()` Alpine gigante, dejar solo estados esenciales en componentes pequeños
   - Mover tema a store
   - Estructura: `<aside sidebar>` + `<main>` con header sticky
2. Refactor `livewire/layout/navigation.blade.php`:
   - Reemplazar SVGs inline por `<x-heroicon-o-*>`
   - Usar tokens primary
   - Submenú abierto derivado de ruta activa (ya existe lógica `$xActive`)
   - Logo wrapper `<x-ui.logo>`
3. Refactor `livewire/layout/header.blade.php`:
   - Breadcrumbs + search global (`Ctrl+K` abre modal Flux command — opcional fase tardía)
   - Theme toggle con `$store.theme`
   - User dropdown con `<flux:dropdown>`
4. Mobile nav: convertir a bottom-nav en `<md` (5 ítems top level) o mantener drawer con Flux
5. Footer minimalista

**Criterio éxito**
- Sidebar desktop + bottom nav mobile funcionando
- Breadcrumbs consistentes en todas las rutas
- Dark mode correcto en todo el shell

### Fase 2 — Átomos UI (2 días)

Crear `resources/views/components/ui/*`. Cada uno con:
- Props tipadas
- Soporte dark mode
- Slots para extensión
- Comentario breve de uso

Botones, inputs, selects → alias / envolturas sobre Flux para ergonomía consistente.

### Fase 3 — Moléculas (1-2 días)

- `page-header` estándar arriba de cada página
- `data-table` refactor: Flux table + toolbar (search, filter dropdown, bulk actions slot)
- `form-field` usado en Formulario de Clientes
- Toast host reemplaza Toastr

### Fase 4 — Piloto Clientes (2-3 días)

**Archivos**
- `resources/views/clientes/index.blade.php`
- `resources/views/clientes/crear.blade.php`
- `resources/views/clientes/mostrar.blade.php`
- `resources/views/livewire/clientes/tabla.blade.php`
- `resources/views/livewire/clientes/formulario.blade.php`
- `resources/views/livewire/clientes/detalle.blade.php`
- `resources/views/livewire/clientes/modal.blade.php`

**Patrón nuevo**

```blade
<x-app-layout>
  <x-ui.page-header
    title="Clientes"
    description="Gestión de clientes de la oficina contable.">
    <x-slot name="actions">
      <flux:button :href="route('clientes.crear')" variant="primary" icon="plus" wire:navigate>
        Nuevo cliente
      </flux:button>
    </x-slot>
  </x-ui.page-header>

  <livewire:clientes.tabla />
</x-app-layout>
```

**Tabla (Livewire)**
- Toolbar: search + filter por tipo + filter por estado
- Columnas: avatar inicial + nombre completo / DPI (mono) / NIT (mono) / tipo (badge) / estado (badge) / acciones
- Paginación Flux
- Empty state con CTA
- Skeleton en `wire:loading.delay`

**Formulario** — dividir en tabs:
1. **Datos personales**: nombres, apellidos, DPI, NIT, email, teléfono, dirección, tipo
2. **Agencia Virtual**: correo, password (toggle show), observaciones
3. **Preferencias** (opcional): estado, notas internas

Usar `<flux:field>` + `<flux:input>` + `<flux:error>` + helper text por campo.

**Detalle** — layout 2 columnas:
- Izq: info del cliente (card)
- Der: tabs **Trámites** (tabla compacta) + **Agencia Virtual** (card credencial) + **Timeline bitácora**

**Criterio éxito**
- Módulo Clientes 100% Flux + tokens nuevos
- Dark mode sin bugs
- Responsive: tabla → cards en mobile
- Sin regresión funcional

### Fase 5 — Demás módulos (1 día por módulo × 7)

Orden sugerido:
1. **Dashboard** — stat-cards nuevos + charts Chart.js con paleta nueva
2. **Trámites** — patrón igual a Clientes + timeline de estado
3. **Tipo Clientes / Tipo Trámites** — simple, reusa data-table
4. **Usuarios** — data-table + role badges
5. **Roles** — cards users por rol, responsive grid
6. **Bitácora** — feed vertical color-coded por tipo (creacion/eliminacion/reporte)
7. **Reportes** — tabs semana/mes/rango + date-range-picker + preview tabla antes de PDF

### Fase 6 — Detalles pro (1-2 días)

- Keyboard shortcuts: `Ctrl+K` búsqueda global, `Esc` cerrar modal, `/` focus search
- Loading states: skeletons tablas, spinners en botones (`wire:loading`)
- Empty states en toda tabla/lista vacía
- Focus rings consistentes: `focus-visible:ring-2 focus-visible:ring-primary-500/60`
- Transiciones: `transition-colors duration-150` global, modal slide-up + fade
- Tabular numerics en montos / DPI / NIT
- Responsive QA en 375 / 768 / 1024 / 1440
- Accesibilidad: contraste verificado, `aria-label` en botones icon-only, `prefers-reduced-motion`
- Limpiar CSS residual e imports obsoletos

### Fase 7 — PDF restyle (1 día)

Templates en `resources/views/pdf/`:
- Header: logo oficina + datos contacto
- Typography: JetBrains Mono en tablas de montos
- Footer: paginación, fecha, generado-por
- Firma / sello placeholder en recibo
- Paleta coherente con UI (primary + neutral)

DomPDF no soporta Tailwind JIT → usar clases core o CSS plano embebido en template.

---

## Estimación total

| Fase | Días | Crítica |
|------|------|---------|
| 0 Foundation + instalar Flux | 1-2 | sí |
| 1 Layout shell + dark mode fix | 1 | sí |
| 2 Átomos UI | 2 | sí |
| 3 Moléculas | 1-2 | sí |
| 4 **Piloto Clientes** | 2-3 | sí (validación) |
| 5 Demás módulos × 7 | 7 | paralelizable |
| 6 Detalles pro | 1-2 | sí |
| 7 PDFs | 1 | no bloqueante |
| **Total** | **16-19** | — |

---

## Archivos clave

| Archivo | Cambio |
|---------|--------|
| `composer.json` | + flux + heroicons |
| `package.json` | + fontsource-variable × 3 |
| `tailwind.config.js` | + primary, + fontFamily display/mono, content Flux stubs |
| `resources/css/app.css` | reescribir componentes, eliminar hamster |
| `resources/js/app.js` | Alpine.store theme |
| `resources/views/layouts/app.blade.php` | pre-paint script, limpiar Alpine data() |
| `resources/views/layouts/guest.blade.php` | restilear auth |
| `resources/views/livewire/layout/navigation.blade.php` | Heroicons, tokens nuevos |
| `resources/views/livewire/layout/navigationMobile.blade.php` | bottom nav |
| `resources/views/livewire/layout/header.blade.php` | $store.theme, Flux dropdown |
| `resources/views/components/` | retirar legacy, añadir `ui/*` |
| `resources/views/livewire/clientes/*` | refactor piloto |
| `resources/views/pdf/*` | fase 7 |

---

## Riesgos y mitigación

| Riesgo | Mitigación |
|--------|-----------|
| Flux estilos chocan con tokens custom | Envolver en componentes propios; override con Tailwind arbitrary values; ajustar tema Flux si es publicable |
| `wire:navigate` rompe Alpine store | Confirmar con piloto; fallback a reload normal en rutas problemáticas |
| Toastr sigue usado en backend flash() | Dejar compat temporal mientras migra `toast-host` |
| DomPDF no soporta fuentes variables | Fuentes estáticas fallback solo para PDFs |
| Regresión visual sin tests | Screenshot manual pre/post por módulo; branch separado hasta merge final |

---

## Orden de ejecución

1. **Aprobar plan** ← aquí estamos
2. **Fase 0**: instalar libs, tokens, fix dark mode
3. **Fase 1**: layout shell
4. **Fase 2-3**: átomos + moléculas
5. **Fase 4**: piloto Clientes → **revisión humana** antes de propagar
6. **Fase 5**: demás módulos (paralelizable)
7. **Fase 6-7**: detalles + PDFs

**Trabajo en branch dedicado** `refactor/ui-v2`. Merge a `main` solo tras revisión completa del piloto.

---

## Siguiente acción

Ejecutar Fase 0:
```bash
composer require livewire/flux blade-ui-kit/blade-heroicons
npm install @fontsource-variable/inter @fontsource-variable/plus-jakarta-sans @fontsource-variable/jetbrains-mono
php artisan flux:activate
```

Tras confirmar, avanzo con cambios de configuración y fix de dark mode.
