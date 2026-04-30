<x-app-layout meta-title="- Inicio">
    <div class="space-y-6">

        {{-- Page header + clock --}}
        <x-ui.page-header title="Panel de Control" description="Resumen general de la oficina contable.">
            <x-slot name="actions">
                <div class="text-right" x-data="clock()" x-init="start()">
                    <p class="text-2xl font-display font-bold text-primary-600 dark:text-primary-400 tabular-nums"
                        x-text="time"></p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 capitalize" x-text="date"></p>
                </div>
            </x-slot>
        </x-ui.page-header>

        {{-- Quick actions --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('tramites.crear') }}" wire:navigate
                class="group flex items-center gap-4 p-5 rounded-lg bg-primary-600 hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600 text-white shadow-card transition-colors duration-150">
                <div class="shrink-0 p-2.5 rounded-lg bg-white/20">
                    <x-heroicon-o-plus class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-display font-semibold text-base leading-tight">Agregar Trámite</p>
                    <p class="text-sm text-primary-100">Registrar nuevo trámite</p>
                </div>
            </a>
            <a href="{{ route('clientes.crear') }}" wire:navigate
                class="group flex items-center gap-4 p-5 rounded-lg bg-brand-600 hover:bg-brand-700 dark:bg-brand-700 dark:hover:bg-brand-600 text-white shadow-card transition-colors duration-150">
                <div class="shrink-0 p-2.5 rounded-lg bg-white/20">
                    <x-heroicon-o-user-plus class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-display font-semibold text-base leading-tight">Agregar Cliente</p>
                    <p class="text-sm text-brand-100">Registrar nuevo cliente</p>
                </div>
            </a>
            <a href="{{ route('reportes.index') }}" wire:navigate
                class="group flex items-center gap-4 p-5 rounded-lg bg-slate-700 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white shadow-card transition-colors duration-150">
                <div class="shrink-0 p-2.5 rounded-lg bg-white/20">
                    <x-heroicon-o-chart-bar class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-display font-semibold text-base leading-tight">Ver Reportes</p>
                    <p class="text-sm text-slate-300">Consultar reportes de trámites</p>
                </div>
            </a>
        </div>

        {{-- Stat cards --}}
        <div @class([
            'grid grid-cols-1 sm:grid-cols-2 gap-4',
            'lg:grid-cols-3' => Auth::user()->role->nombre === 'Administrador',
        ])>
            <x-ui.stat-card label="Trámites Activos" :value="$totalTramites . ' ' . ($totalTramites === 1 ? 'Trámite' : 'Trámites')" icon="briefcase" color="primary" />
            <x-ui.stat-card label="Clientes Activos" :value="$totalClientes . ' ' . ($totalClientes === 1 ? 'Cliente' : 'Clientes')" icon="users" color="brand" />
            @if (Auth::user()->role->nombre === 'Administrador')
                <x-ui.stat-card label="Honorarios del Mes" :value="'Q ' . number_format($gastoTotal, 2)" icon="banknotes" color="emerald" />
            @endif
        </div>

        @php
            $dashboardChartOptions = [
                'plugins' => [
                    'legend' => [
                        'position' => 'top',
                        'labels' => [
                            'font' => ['family' => 'Inter Variable, sans-serif', 'size' => 12],
                        ],
                    ],
                ],
                'scales' => [
                    'x' => ['ticks' => ['font' => ['size' => 12]]],
                    'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0, 'font' => ['size' => 12]]],
                ],
            ];
        @endphp

        {{-- Chart --}}
        <x-ui.section title="Estadísticas" description="Clientes y trámites de los últimos 6 meses">
            <div class="relative h-80">
                <canvas id="dashboardChart" class="hidden sm:block w-full h-full"
                    data-chart='@json($chartData)'
                    data-chart-options='@json($dashboardChartOptions)'></canvas>
                <div
                    class="flex sm:hidden items-center justify-center h-full text-sm text-slate-500 dark:text-slate-400">
                    <x-heroicon-o-device-phone-mobile class="w-5 h-5 mr-2" />
                    Amplía la ventana para ver la gráfica
                </div>
            </div>
        </x-ui.section>

        {{-- Recent records --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Últimos trámites --}}
            <x-ui.section title="Últimos Trámites" :padding="false">
                <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($ultimosTramites as $tramite)
                        <li class="flex items-start justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">
                                    {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                    {{ $tramite->tipoTramite->nombre }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                                    {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                </p>
                            </div>
                            <div class="shrink-0 text-right">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 tabular-nums">
                                    Q{{ number_format($tramite->precio, 2) }}
                                </p>
                                @if ($tramite->estado)
                                    <span class="badge-active">Activo</span>
                                @else
                                    <span class="badge-inactive">Inactivo</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-400 dark:text-slate-500">
                            Sin trámites recientes
                        </li>
                    @endforelse
                </ul>
            </x-ui.section>

            {{-- Últimos clientes --}}
            <x-ui.section title="Últimos Clientes" :padding="false">
                <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($ultimosClientes as $cliente)
                        <li class="flex items-start justify-between gap-3 px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                    <span class="text-xs font-bold text-primary-600 dark:text-primary-400">
                                        {{ strtoupper(substr($cliente->nombres, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">
                                        {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                        {{ $cliente->email }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                                        {{ $cliente->telefono }}</p>
                                </div>
                            </div>
                            <div class="shrink-0">
                                @if ($cliente->estado)
                                    <span class="badge-active">Activo</span>
                                @else
                                    <span class="badge-inactive">Inactivo</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-400 dark:text-slate-500">
                            Sin clientes recientes
                        </li>
                    @endforelse
                </ul>
            </x-ui.section>

        </div>
    </div>

    @push('scripts')
        <script>
            function clock() {
                return {
                    time: '',
                    date: '',
                    start() {
                        this.tick();
                        setInterval(() => this.tick(), 1000);
                    },
                    tick() {
                        const now = new Date();
                        this.time = now.toLocaleTimeString('es-ES', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        this.date = now.toLocaleDateString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
