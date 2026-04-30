<div class="space-y-5">

    {{-- Info card --}}
    <x-ui.section>
        <x-slot name="headerActions">
            <button wire:click="editar({{ $tipoTramite->id }})" class="btn-secondary text-sm">
                <x-heroicon-o-pencil class="w-4 h-4 text-orange-600" />
                Editar
            </button>
        </x-slot>

        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 mb-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="text-xl font-display font-semibold text-slate-900 dark:text-slate-100">
                {{ $tipoTramite->nombre }}
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Fecha de
                    creación</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                    {{ $tipoTramite->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Trámites
                    realizados</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                    {{ $tipoTramite->tramites->count() }}
                    {{ $tipoTramite->tramites->count() === 1 ? 'trámite' : 'trámites' }}
                </p>
            </div>
        </div>
    </x-ui.section>

    @php
        $tipoTramiteChartOptions = [
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'labels' => ['font' => ['size' => 12]],
                ],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    @endphp

    {{-- Chart --}}
    <x-ui.section title="Estadísticas" description="Trámites de este tipo en los últimos 6 meses">
        <div class="relative h-72">
            <canvas id="tipoTramiteChart" class="hidden sm:block w-full h-full"
                data-chart='@json($chartData)' data-chart-options='@json($tipoTramiteChartOptions)'></canvas>
            <div class="flex sm:hidden items-center justify-center h-full text-sm text-slate-500 dark:text-slate-400">
                <x-heroicon-o-device-phone-mobile class="w-5 h-5 mr-2" />
                Amplía la ventana para ver la gráfica
            </div>
        </div>
    </x-ui.section>

    {{-- Associated tramites table --}}
    <x-ui.section :padding="false">
        <x-slot name="headerActions">
            <a href="{{ route('tramites.index') }}" wire:navigate
                class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                Ver todos los trámites
                <x-heroicon-o-arrow-right class="w-4 h-4" />
            </a>
        </x-slot>
        <x-slot name="title">Últimos trámites realizados</x-slot>

        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="table-header w-12">#</th>
                        <th class="table-header">Cliente</th>
                        <th class="table-header w-28">Precio</th>
                        <th class="table-header w-28">Gastos</th>
                        <th class="table-header w-28">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($tipoTramite->tramites->sortByDesc('created_at')->take(5) as $tramite)
                        <tr class="table-row">
                            <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="table-cell font-medium text-slate-800 dark:text-slate-200">
                                {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                            </td>
                            <td class="table-cell text-center num font-semibold text-slate-800 dark:text-slate-200">
                                Q {{ number_format($tramite->precio, 2) }}
                            </td>
                            <td class="table-cell text-center num text-rose-600 dark:text-rose-400">
                                Q {{ number_format($tramite->gastos, 2) }}
                            </td>
                            <td class="table-cell text-center num text-slate-500 dark:text-slate-400">
                                {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state py-10">
                                    <x-heroicon-o-briefcase />
                                    <p>Sin trámites asociados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.section>

</div>
