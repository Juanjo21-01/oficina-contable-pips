<div class="space-y-5">

    {{-- Info card --}}
    <x-ui.section>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 mb-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="text-xl font-display font-semibold text-slate-900 dark:text-slate-100">
                {{ $tipoCliente->nombre }}
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Fecha de
                    creación</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                    {{ $tipoCliente->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Clientes
                    asociados</p>
                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                    {{ $tipoCliente->clientes->count() }}
                    {{ $tipoCliente->clientes->count() === 1 ? 'cliente' : 'clientes' }}
                </p>
            </div>
        </div>
    </x-ui.section>

    @php
        $tipoClienteChartOptions = [
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
    <x-ui.section title="Estadísticas" description="Clientes de este tipo en los últimos 6 meses">
        <div class="relative h-72">
            <canvas id="tipoClienteChart" class="hidden sm:block w-full h-full"
                data-chart='@json($chartData)' data-chart-options='@json($tipoClienteChartOptions)'></canvas>
            <div class="flex sm:hidden items-center justify-center h-full text-sm text-slate-500 dark:text-slate-400">
                <x-heroicon-o-device-phone-mobile class="w-5 h-5 mr-2" />
                Amplía la ventana para ver la gráfica
            </div>
        </div>
    </x-ui.section>

    {{-- Associated clients table --}}
    <x-ui.section :padding="false">
        <x-slot name="headerActions">
            <a href="{{ route('clientes.index') }}" wire:navigate
                class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                Ver todos los clientes
                <x-heroicon-o-arrow-right class="w-4 h-4" />
            </a>
        </x-slot>
        <x-slot name="title">Últimos clientes asociados</x-slot>

        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="table-header w-12">#</th>
                        <th class="table-header">Nombre</th>
                        <th class="table-header">DPI</th>
                        <th class="table-header">Correo</th>
                        <th class="table-header">NIT</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($tipoCliente->clientes->sortByDesc('created_at')->take(5) as $cliente)
                        <tr class="table-row">
                            <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="table-cell">
                                <p class="font-medium text-slate-800 dark:text-slate-200">
                                    {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                </p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 truncate max-w-xs">
                                    {{ $cliente->direccion }}
                                </p>
                            </td>
                            <td class="table-cell text-center num text-slate-600 dark:text-slate-400">
                                {{ $cliente->dpi }}
                            </td>
                            <td class="table-cell text-center text-slate-600 dark:text-slate-400">
                                {{ $cliente->email }}
                            </td>
                            <td class="table-cell text-center num text-slate-600 dark:text-slate-400">
                                {{ $cliente->nit }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state py-10">
                                    <x-heroicon-o-users />
                                    <p>Sin clientes asociados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.section>

</div>
