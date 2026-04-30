<div class="space-y-5">

    {{-- ── Info card ────────────────────────────────────────────────── --}}
    <x-ui.section>
        <x-slot name="headerActions">
            <div class="flex items-center gap-2">
                <button wire:click="cambiarEstado({{ $tramite->id }})"
                    class="{{ !$tramite->estado ? 'btn-secondary' : 'btn-secondary' }} text-sm">
                    @if (!$tramite->estado)
                        <x-heroicon-o-arrow-path class="w-4 h-4 text-brand-600" />
                        Activar
                    @else
                        <x-heroicon-o-pause-circle class="w-4 h-4 text-amber-600" />
                        Desactivar
                    @endif
                </button>
                <button wire:click="editar({{ $tramite->id }})" class="btn-secondary text-sm">
                    <x-heroicon-o-pencil class="w-4 h-4 text-orange-600" />
                    Editar
                </button>
                <a href="{{ route('tramites.pdf', $tramite->id) }}" target="_blank" rel="noopener noreferrer"
                    class="btn-secondary text-sm">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4 text-primary-600" />
                    Recibo PDF
                </a>
            </div>
        </x-slot>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 mb-4 border-b border-slate-100 dark:border-slate-700">
            <div>
                <h2 class="text-xl font-display font-semibold text-slate-900 dark:text-slate-100">
                    {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    {{ $tramite->tipoTramite->nombre }}
                </p>
            </div>
            @if ($tramite->estado)
                <span class="badge-active">Activo</span>
            @else
                <span class="badge-inactive">Inactivo</span>
            @endif
        </div>

        {{-- Detail grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Fecha</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                    {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Precio</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                    Q {{ number_format($tramite->precio, 2) }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Gastos</p>
                <p class="mt-1 text-sm font-semibold text-rose-600 dark:text-rose-400 num">
                    Q {{ number_format($tramite->gastos, 2) }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Total remanente</p>
                <p class="mt-1 text-sm font-bold text-emerald-600 dark:text-emerald-400 num">
                    Q {{ number_format($tramite->precio - $tramite->gastos, 2) }}
                </p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Observaciones</p>
                <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">
                    {{ $tramite->observaciones ?? '—' }}
                </p>
            </div>
        </div>
    </x-ui.section>

    {{-- ── Receipt preview ─────────────────────────────────────────── --}}
    <x-ui.section title="Vista previa del recibo">
        <div class="w-full md:w-3/4 lg:w-1/2 mx-auto">

            {{-- Receipt header --}}
            <div class="text-center pb-4 mb-4 border-b border-slate-200 dark:border-slate-700">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto h-14 mb-2 object-contain">
                <h2 class="text-lg font-display font-semibold text-slate-800 dark:text-slate-200">Recibo de Trámite</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Oficina Contable "Méndez García & Asociados"</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">7° avenida 3-40, Zona 2, San Pedro Sacatepéquez San Marcos</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tel: 5861-2987 / 5611-6232</p>
                <div class="flex justify-center gap-4 mt-2 text-xs text-slate-500 dark:text-slate-400">
                    <span>Fecha: {{ date('d/m/Y') }}</span>
                    <span>Recibo No. #{{ $tramite->id }}</span>
                </div>
            </div>

            {{-- Client info --}}
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Información del cliente</h3>
                <div class="space-y-1 text-xs text-slate-600 dark:text-slate-400">
                    <p><span class="font-medium">Nombre:</span> {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}</p>
                    <p><span class="font-medium">Dirección:</span> {{ $tramite->cliente->direccion }}</p>
                    <p><span class="font-medium">Teléfono:</span> <span class="num">{{ $tramite->cliente->telefono }}</span></p>
                    <p><span class="font-medium">NIT:</span> <span class="num">{{ $tramite->cliente->nit }}</span></p>
                </div>
            </div>

            {{-- Tramite detail --}}
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Detalles del trámite</h3>
                <div class="space-y-1 text-xs text-slate-600 dark:text-slate-400">
                    <div class="flex justify-between">
                        <span>Concepto:</span>
                        <span>{{ $tramite->observaciones ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Fecha de servicio:</span>
                        <span class="num">{{ date('d/m/Y', strtotime($tramite->fecha)) }}</span>
                    </div>
                </div>
            </div>

            {{-- Services table --}}
            <table class="w-full text-xs mb-3">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-2 text-slate-600 dark:text-slate-400 font-semibold">Descripción</th>
                        <th class="text-right py-2 text-slate-600 dark:text-slate-400 font-semibold">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 text-slate-700 dark:text-slate-300">{{ $tramite->tipoTramite->nombre }}</td>
                        <td class="py-2 text-right text-slate-800 dark:text-slate-200 num font-medium">
                            Q {{ number_format($tramite->precio, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-between text-xs text-rose-600 dark:text-rose-400 mb-3">
                <span>Gastos</span>
                <span class="num">− Q {{ number_format($tramite->gastos, 2) }}</span>
            </div>

            <div class="flex justify-between font-semibold text-sm text-slate-800 dark:text-slate-200 pt-3 border-t border-slate-200 dark:border-slate-700">
                <span>Total Remanente</span>
                <span class="num text-emerald-600 dark:text-emerald-400">
                    Q {{ number_format($tramite->precio - $tramite->gastos, 2) }}
                </span>
            </div>

            {{-- Signature --}}
            <div class="mt-8 text-center">
                <div class="border-t border-slate-400 dark:border-slate-600 w-2/5 mx-auto mb-1"></div>
                <p class="text-xs text-slate-400 dark:text-slate-500">Firma del cliente</p>
            </div>
        </div>
    </x-ui.section>

</div>
