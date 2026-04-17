# Plan de Mejoras UI/UX — Gestor de Clientes PIPS
> Méndez García & Asociados · Laravel 11 + Livewire 3 + Tailwind CSS
> Skills aplicadas: `frontend-design` · `ui-ux-pro-max`

---

## Diagnóstico General

| Área | Estado Actual | Problema Principal |
|------|--------------|-------------------|
| Sistema de diseño | Inconsistente | Mezcla sky-600 (login) con teal-600 (app) sin token único |
| Tipografía | Funcional | Sin jerarquía visual clara; tamaños arbitrarios |
| Espaciado | Inconsistente | Padding/gap distintos entre vistas similares |
| Componentes | Repetidos | Código duplicado en cada tabla Livewire |
| Feedback visual | Mínimo | Sin estados vacíos, loading skeletons ni micro-animaciones |
| Dashboard | Básico | Cards sin iconografía consistente, gráfico sin filtros |
| Formularios | Funcional | Sin progress steps en formularios largos, UX de búsqueda mejorable |
| Modales | Correctos | Falta animación de entrada y manejo de foco visible |
| Responsive | Parcial | Tablas se cortan en mobile, toolbar mal apilada |
| PDF templates | Sin estilo | Recibos sin identidad visual de marca |

---

## Principios de Diseño a Aplicar

1. **Design Tokens primero** — definir la paleta, tipografía y espaciado como variables antes de tocar componentes.
2. **Atomic Design** — base → componentes → páginas; nada al revés.
3. **Progressive Enhancement** — la UI funciona sin JS; Livewire y Alpine añaden capas de mejora.
4. **Accesibilidad WCAG 2.1 AA** — contraste mínimo 4.5:1, foco visible, labels semánticos.
5. **Dark Mode first** — revisar todos los tokens en ambos modos antes de cada entrega.

---

## Fases de Implementación

---

### FASE 1 — Fundamentos del Sistema de Diseño
> **Objetivo:** Establecer la base visual unificada antes de modificar cualquier vista.
> **Impacto:** Alto · **Riesgo:** Bajo · **Estimado:** 1–2 días

#### 1.1 Design Tokens en `tailwind.config.js`

```
Archivo: tailwind.config.js
```

**Cambios:**
- Unificar color primario: renombrar `sky` del login a `teal` (un solo token `brand`).
- Añadir tokens semánticos:
  - `color.brand.*` → teal (primario)
  - `color.surface.*` → grays para fondos
  - `color.content.*` → grays para textos
  - `color.status.success/warning/danger/info`
  - `color.action.view/edit/delete/add`
- Definir escala de espaciado semántica: `space.xs/sm/md/lg/xl`
- Definir `borderRadius` consistente: `card`, `badge`, `button`

**Resultado:** Un único lugar donde cambiar colores afecta toda la app.

---

#### 1.2 Variables CSS Base en `resources/css/app.css`

```
Archivo: resources/css/app.css
```

**Cambios:**
- Añadir `@layer base` con variables CSS `--color-brand`, `--color-surface`, etc.
- Añadir clases utilitarias reutilizables:
  - `.card` → `bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700`
  - `.badge-active` / `.badge-inactive` → tokens de estado
  - `.btn-primary` / `.btn-secondary` / `.btn-danger` → botones base
  - `.table-header` → encabezado de tabla uniforme
- Añadir `@layer components` para clases compuestas (evitar repetición en Blade).
- Optimizar animación hamster: extraer en `@keyframes` separados y comentar.

---

#### 1.3 Componente Blade `<x-status-badge>`

```
Archivo: resources/views/components/status-badge.blade.php  [NUEVO]
```

**Props:** `status` (string: active|inactive|pending|completed)

**Reemplaza:** Los 6+ bloques `@if ($estado === 'Activo')` repetidos en todas las tablas.

---

#### 1.4 Componente Blade `<x-action-buttons>`

```
Archivo: resources/views/components/action-buttons.blade.php  [NUEVO]
```

**Props:** `viewRoute`, `editEvent`, `deleteEvent`, `showView`, `showEdit`, `showDelete`

**Reemplaza:** El bloque de botones (ver/editar/eliminar) repetido en las 4 tablas Livewire.

---

#### 1.5 Componente Blade `<x-data-table>`

```
Archivo: resources/views/components/data-table.blade.php  [NUEVO]
```

**Props:** `columns` (array), slot para filas, `emptyMessage`

**Incluye:**
- Estado vacío (empty state) con ícono y mensaje configurable.
- Loading skeleton (Livewire `wire:loading`).
- Encabezados con sort indicators (preparado para futura ordenación).

---

### FASE 2 — Layout y Navegación
> **Objetivo:** Mejorar la estructura visual global y la navegación.
> **Impacto:** Alto · **Riesgo:** Medio · **Estimado:** 1–2 días

#### 2.1 Sidebar Navigation (`livewire/layout/navigation.blade.php`)

**Mejoras:**
- Añadir **tooltips** en modo colapsado (preparar toggle de colapso `w-64 → w-16`).
- Mejorar íconos: homogeneizar tamaño (`w-5 h-5` en todos).
- Añadir **indicador de sección activa** más prominente: borde izquierdo teal-600 + fondo teal-50/dark:teal-900/20.
- Separadores visuales (`<hr>`) entre grupos de navegación (Admin / Gestión / Reportes).
- **Badge numérico** en Trámites (conteo de pendientes) — datos desde Livewire.
- Agregar **avatar/iniciales del usuario** en la parte inferior del sidebar.
- Transición de colapso/expansión fluida con `transition-all duration-300`.

#### 2.2 Header (`livewire/layout/header.blade.php`)

**Mejoras:**
- Añadir **breadcrumb dinámico** (ruta actual → componente `<x-breadcrumb>`).
- Mejorar dropdown de usuario: foto/avatar generado con iniciales + color.
- Mover el toggle de tema a un botón más accesible con `aria-label`.
- Añadir **indicador de notificaciones** (ícono campana, preparado para futuras notificaciones).
- Altura fija consistente (`h-16`) para evitar reflow en Livewire updates.

#### 2.3 Mobile Navigation (`livewire/layout/navigationMobile.blade.php`)

**Mejoras:**
- Añadir **overlay con blur** (`backdrop-blur-sm`) al abrir.
- Mejorar animación: `translate-x-full → translate-x-0` (slide desde izquierda).
- Botón de cierre más grande y accesible (`p-3` mínimo, `touch-target`).
- Mantener posición de scroll al cerrar y reabrir.

#### 2.4 Footer (`layouts/footer.blade.php`)

**Mejoras:**
- Reducir altura — actualmente ocupa demasiado espacio vertical en pantallas pequeñas.
- Simplificar a una sola línea en mobile.
- Mejorar contraste del texto de atribución.

---

### FASE 3 — Dashboard
> **Objetivo:** Convertir el dashboard en un panel informativo real y visualmente atractivo.
> **Impacto:** Muy Alto · **Riesgo:** Bajo · **Estimado:** 2–3 días

#### 3.1 Hero / Welcome Card

**Mejoras:**
- Reemplazar gradiente plano por **card glassmorphism** con fondo teal degradado.
- Mostrar: nombre del usuario, rol, última sesión.
- Reloj en tiempo real mantenerlo pero con tipografía más grande y elegante.
- Añadir **estado del sistema** (trámites pendientes del día).

#### 3.2 Tarjetas de Estadísticas (KPI Cards)

**Rediseño completo:**
```
┌─────────────────────────────┐
│  [Ícono coloreado]   [+12%] │
│                             │
│  247                        │
│  Total Trámites             │
│  ─────────────────          │
│  vs mes anterior: +18       │
└─────────────────────────────┘
```
- Añadir **tendencia** (porcentaje vs mes anterior) con flecha ↑↓ coloreada.
- Hover: elevación con `shadow-xl` + ligero `scale-105`.
- Ícono con fondo de color suave (no emoji, Heroicons consistentes).
- Transición de números con `CountUp.js` o CSS counter animation.

#### 3.3 Gráfico de Estadísticas

**Mejoras:**
- Añadir **selector de período** (semana / mes / trimestre / año) sin recargar página.
- Usar Chart.js con tema personalizado que respete el dark mode automáticamente.
- Añadir segundo dataset (Clientes nuevos vs Trámites) en gráfico combinado.
- Tooltip mejorado con formato de moneda y fechas en español.
- Añadir leyenda interactiva (clic para mostrar/ocultar series).

#### 3.4 Quick Actions

**Mejoras:**
- Convertir los 3 botones en **tarjetas de acción** con ícono grande y descripción corta.
- Añadir acceso directo a "Ver Reportes del mes" y "Bitácora reciente".
- Layout: 2 columnas en mobile, 3–4 en desktop.

#### 3.5 Tablas Recientes

**Mejoras:**
- Reemplazar listas simples por **mini-cards** con más información contextual.
- Añadir estado visual claro (badge de estado en cada ítem).
- "Ver todos →" link al final de cada sección.
- Skeleton loading mientras carga Livewire.

---

### FASE 4 — Tablas de Datos (Livewire)
> **Objetivo:** Tablas más usables, rápidas y visualmente consistentes.
> **Impacto:** Muy Alto · **Riesgo:** Medio · **Estimado:** 2–3 días

#### 4.1 Toolbar Unificado (aplicar a las 4 tablas)

**Rediseño del toolbar:**
```
┌──────────────────────────────────────────────────────────────┐
│ [+ Agregar]    [🔍 Buscar...........] [Estado ▾] [10 ▾] [⚙] │
└──────────────────────────────────────────────────────────────┘
```
- Búsqueda con ícono integrado (no label externo).
- Filtros como `<x-select-filter>` componente reutilizable.
- Botón "+" prominente con ícono + texto en desktop, solo ícono en mobile.
- Botón de opciones avanzadas `⚙` para filtros adicionales (expandible).
- Contador de resultados: "Mostrando 10 de 247 registros".

#### 4.2 Tabla: Clientes (`livewire/clientes/tabla.blade.php`)

**Mejoras específicas:**
- Columna Nombres: añadir **avatar con iniciales** + nombre completo + dirección como subtexto.
- Añadir columna **Tipo de Cliente** con badge de color por tipo.
- Condensar DPI/NIT en una sola columna de 2 líneas para ganar espacio.
- **Acción de estado** como toggle switch (`<x-toggle>`) en lugar de botón texto.
- Row hover: `bg-teal-50/50 dark:bg-teal-900/10` para indicar seleccionabilidad.
- Click en la fila completa → ver detalle (no solo el botón).

#### 4.3 Tabla: Trámites (`livewire/tramites/tabla.blade.php`)

**Mejoras específicas:**
- Columna Cliente: mostrar nombre + tipo de cliente como subtexto.
- Columna Precio: alinear a la derecha con formato moneda `Q 1,250.00`.
- Añadir columna **Gastos** y **Ganancia neta** (precio − gastos) en color teal.
- Estado: añadir color semántico para estados intermedios (En proceso, Completado, Cancelado).
- Añadir **filtro de fecha** (rango) en el toolbar.
- Fila expandible (acordeón) para ver observaciones sin abrir modal.

#### 4.4 Tabla: Usuarios (`livewire/usuarios/tabla.blade.php`)

**Mejoras específicas:**
- Avatar con iniciales coloreadas según rol.
- Badge de rol con color específico por rol.
- Columna Estado como toggle switch accesible.
- Protección visual: fila del Admin con estilo diferenciado (no eliminable).

#### 4.5 Tabla: Roles (`livewire/roles/tabla.blade.php`)

**Mejoras específicas:**
- Mostrar lista de permisos como mini-badges en la fila.
- Contador de usuarios con ícono de persona.
- Expandir a ancho completo (quitar el `lg:w-3/4` arbitrario).

#### 4.6 Empty States (aplicar a todas las tablas)

```
┌─────────────────────────────────┐
│         [Ícono grande]          │
│    No hay clientes registrados  │
│    Agrega el primero ahora →    │
│       [+ Agregar Cliente]       │
└─────────────────────────────────┘
```
- Ícono SVG relevante por tabla.
- Mensaje contextual (diferente si hay búsqueda activa vs tabla vacía).
- CTA directo al formulario de creación.

#### 4.7 Loading States

- `wire:loading` skeleton en cada tabla: filas grises animadas mientras carga.
- Spinner en botones de acción al procesar.
- Deshabilitar toolbar durante operaciones Livewire.

---

### FASE 5 — Formularios
> **Objetivo:** Formularios más guiados, claros y con mejor UX de validación.
> **Impacto:** Alto · **Riesgo:** Medio · **Estimado:** 2 días

#### 5.1 Componente `<x-form-section>` (Tarjeta de formulario)

```
Archivo: resources/views/components/form-section.blade.php  [NUEVO]
```

**Estandarizar el patrón de card de formulario:**
- Header con ícono + título + descripción opcional.
- Contenido en grid configurable (1/2/3 columnas).
- Footer con botones de acción alineados a la derecha.
- Indicador de campos requeridos (`*`) con leyenda al pie.

#### 5.2 Formulario de Clientes (`livewire/clientes/formulario.blade.php`)

**Mejoras:**
- **Progress steps visual** en la parte superior: `Información → Datos Fiscales → Confirmar`.
- Validación en tiempo real con indicador verde ✓ por campo.
- Máscara de formato para DPI (####-#####-####) y teléfono.
- Campo Email con verificación de formato en tiempo real.
- Estado de "guardando..." en el botón submit con spinner.
- Botón "Cancelar" que pregunta si hay cambios sin guardar.

#### 5.3 Formulario de Trámites (`livewire/tramites/formulario.blade.php`)

**Mejoras:**
- **Búsqueda de cliente mejorada**: dropdown con avatar + nombre + DPI para identificar.
- **Autocompletado inteligente**: al seleccionar tipo de trámite, pre-llenar precio sugerido.
- Campo Precio y Gastos: formato numérico con separador de miles.
- Mostrar **ganancia calculada en tiempo real** (precio − gastos) mientras se escribe.
- Selector de fecha con calendario (Flatpickr o HTML5 date con estilo Tailwind).
- Sección de Observaciones con contador de caracteres.

#### 5.4 Modal de Edición Unificado

**Mejoras para todos los modales:**
- Animación de entrada: `scale-95 opacity-0 → scale-100 opacity-100` (ya existe, mejorar timing).
- Header con color semántico: teal para crear, amber para editar.
- Foco automático en el primer campo al abrir.
- Cierre con `Escape` con confirmación si hay cambios.
- Botones: "Guardar" (primario) + "Cancelar" (secundario), nunca solo "X".
- Ancho adaptativo: sm para confirmaciones, md para formularios simples, lg para formularios completos.

#### 5.5 Feedback de Éxito/Error

**Mejorar el sistema de Toastr:**
- Posición: `top-right` consistente en todas las vistas.
- Duración: 3s éxito, 5s error (no autocierre en errores críticos).
- Icono visual diferenciado por tipo (✓ / ✗ / ⚠ / ℹ).
- Stack de notificaciones (máximo 3 visibles al mismo tiempo).

---

### FASE 6 — Páginas de Autenticación
> **Objetivo:** Mejorar la primera impresión y coherencia de marca.
> **Impacto:** Medio · **Riesgo:** Bajo · **Estimado:** 1 día

#### 6.1 Layout Guest (`layouts/guest.blade.php`)

**Rediseño:**
- Panel izquierdo: reemplazar imagen estática por **fondo con gradiente animado** + logo centrado + tagline de la empresa.
- Añadir patrón geométrico SVG sutil en el fondo del panel izquierdo.
- Panel derecho: centrar mejor el formulario, añadir separación visual más generosa.

#### 6.2 Página de Login (`livewire/pages/auth/login.blade.php`)

**Mejoras:**
- **Unificar color del botón** a `teal-600` (actualmente usa `sky-600`, inconsistente).
- Añadir logo de la empresa sobre el formulario.
- Mostrar/ocultar contraseña (toggle ojo).
- Mejor manejo de errores: campo con borde rojo + mensaje inline (no solo toast).
- Añadir animación de shake en el formulario cuando las credenciales son incorrectas.
- Texto "Recordarme" más descriptivo.

---

### FASE 7 — Páginas de Perfil y Reportes
> **Objetivo:** Mejorar usabilidad de páginas secundarias importantes.
> **Impacto:** Medio · **Riesgo:** Bajo · **Estimado:** 1–2 días

#### 7.1 Perfil de Usuario (`profile.blade.php`)

**Mejoras:**
- Añadir **foto de perfil** (upload o avatar generado con iniciales + color por hash).
- Card de información: layout de 3 columnas con datos del usuario de forma prominente.
- Sección de cambio de contraseña: indicador de fortaleza de contraseña en tiempo real.
- Historial reciente (clientes y trámites) en tabs en lugar de secciones separadas.
- Añadir sección "Actividad reciente" basada en bitácora.

#### 7.2 Reportes (`reportes/`)

**Mejoras:**
- **Selector de tipo de reporte** como tarjetas visuales (no dropdown).
- Rango de fechas con date-range picker visual.
- **Preview del reporte** antes de generar PDF (tabla en la página).
- Botón de descarga con ícono PDF + nombre del archivo sugerido.
- Historial de reportes generados en la sesión.

#### 7.3 Bitácora (`livewire/bitacora/`)

**Mejoras:**
- Timeline visual en lugar de tabla plana.
- Ícono por tipo de acción (creación ✓ verde / eliminación ✗ rojo / reporte 📄 azul).
- Filtros: por usuario, tipo de acción, rango de fechas.
- Expandir entrada para ver descripción completa.

---

### FASE 8 — Templates PDF
> **Objetivo:** Recibos y reportes con identidad visual profesional.
> **Impacto:** Alto (imagen de empresa) · **Riesgo:** Bajo · **Estimado:** 1 día

#### 8.1 Recibo de Trámite (`views/pdf/recibo.blade.php`)

**Rediseño completo:**
```
┌─────────────────────────────────────┐
│  LOGO    Méndez García & Asociados  │
│          Tel / Email / Dirección    │
├─────────────────────────────────────┤
│  RECIBO DE HONORARIOS  #000247      │
│  Fecha: 16/04/2026                  │
├─────────────────────────────────────┤
│  Cliente: Juan García               │
│  DPI: 2345-67890-0101               │
│  NIT: 12345-6                       │
├─────────────────────────────────────┤
│  CONCEPTO           MONTO           │
│  Trámite de XX      Q 1,250.00      │
│  Gastos             Q   150.00      │
│  ─────────────────────────────      │
│  TOTAL              Q 1,100.00      │
├─────────────────────────────────────┤
│  Firma: _______________             │
│  Sello                              │
└─────────────────────────────────────┘
```
- Cabecera con logo + datos de la empresa.
- Número de recibo correlativo.
- Desglose de precio / gastos / neto.
- Área de firma y sello.
- Pie con datos legales.
- Color teal para cabecera y totales.

#### 8.2 Reporte General (`views/pdf/reporte.blade.php`)

**Mejoras:**
- Portada con período del reporte y logo.
- Resumen ejecutivo (KPIs del período) en tabla visual.
- Tabla de detalle con zebra striping.
- Pie de página con numeración y fecha de generación.
- Gráfico de barras embebido (DomPDF soporta imágenes base64).

---

### FASE 9 — Páginas de Error
> **Objetivo:** Mejorar la experiencia en estados de error.
> **Impacto:** Bajo · **Riesgo:** Muy Bajo · **Estimado:** 0.5 días

#### 9.1 Error Pages (404, 403, 500)

**Mejoras:**
- Mantener la animación del hamster (es un diferenciador divertido).
- Añadir **mensaje de ayuda contextual** por código de error.
- Botón "Volver atrás" + "Ir al Dashboard" (dos opciones).
- Reportar error 500 (link al email de soporte).
- Mejorar tipografía: el `text-8xl` del número es correcto, añadir más contexto visual.
- Fondo con patrón sutil (no color plano).

---

## Orden de Implementación Definitivo

| # | Fase | Componentes | Prioridad | Días |
|---|------|-------------|-----------|------|
| 1 | Design Tokens + CSS base | `tailwind.config.js`, `app.css`, 3 componentes Blade nuevos | 🔴 Crítico | 1–2 |
| 2 | Layout y Navegación | `navigation.blade.php`, `header.blade.php`, `navigationMobile.blade.php` | 🔴 Crítico | 1–2 |
| 3 | Dashboard | `dashboard.blade.php`, Chart.js config | 🟠 Alto | 2–3 |
| 4 | Tablas de Datos | 4 tablas Livewire + empty states + loading | 🟠 Alto | 2–3 |
| 5 | Formularios | 2 formularios + modales + sistema toastr | 🟠 Alto | 2 |
| 6 | Autenticación | `guest.blade.php`, `login.blade.php` | 🟡 Medio | 1 |
| 7 | Perfil y Reportes | `profile.blade.php`, `reportes/`, `bitacora/` | 🟡 Medio | 1–2 |
| 8 | PDFs | `recibo.blade.php`, `reporte.blade.php` | 🟡 Medio | 1 |
| 9 | Error Pages | `404.blade.php`, `403.blade.php`, `500.blade.php` | 🟢 Bajo | 0.5 |
| | **TOTAL** | **~40 archivos afectados** | | **~14–17 días** |

---

## Nuevos Archivos a Crear

```
resources/views/components/
├── status-badge.blade.php          ← Fase 1
├── action-buttons.blade.php        ← Fase 1
├── data-table.blade.php            ← Fase 1
├── form-section.blade.php          ← Fase 5
├── breadcrumb.blade.php            ← Fase 2
├── select-filter.blade.php         ← Fase 4
├── toggle.blade.php                ← Fase 4
└── avatar-initials.blade.php       ← Fase 2 / 4
```

---

## Dependencias y Riesgos

| Riesgo | Mitigación |
|--------|-----------|
| Livewire re-renders pueden perder clases CSS dinámicas | Usar `wire:key` en todos los loops; clases estáticas en componentes |
| Dark mode inconsistente en nuevos componentes | Revisar cada nuevo componente en ambos modos antes de merge |
| DomPDF no soporta todas las propiedades CSS3 (PDF) | Usar CSS inline básico en templates PDF; probar con `npm run build` |
| Alpine.js conflicto con nuevos componentes interactivos | Namespace los componentes Alpine (`x-data="componentName()"`) |
| Toastr puede conflictuar con nuevas notificaciones Livewire | Evaluar migrar a `wire:dispatch` + componente Blade nativo |

---

## Métricas de Éxito

- [ ] Lighthouse Performance ≥ 85 (actualmente estimado ~70)
- [ ] Lighthouse Accessibility ≥ 90
- [ ] 0 errores de contraste WCAG AA
- [ ] Tiempo de carga del dashboard < 1.5s (LCP)
- [ ] Todas las tablas operables en pantalla 375px sin scroll horizontal
- [ ] Dark mode al 100% sin elementos con colores hardcoded
