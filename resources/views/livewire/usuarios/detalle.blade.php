<div>
    @if (Auth::user()->role->nombre === 'Administrador')
        <div class="space-y-5">

            {{-- Profile card --}}
            <x-ui.section>
                <x-slot name="headerActions">
                    <div class="flex items-center gap-2">
                        <button wire:click="cambiarEstado({{ $usuario->id }})" @class([
                            'btn-secondary text-sm',
                            'opacity-50 cursor-not-allowed' =>
                                $usuario->role->nombre === 'Administrador',
                        ])
                            @disabled($usuario->role->nombre === 'Administrador')>
                            @if (!$usuario->estado)
                                <x-heroicon-o-arrow-path class="w-4 h-4 text-brand-600" />
                                Activar
                            @else
                                <x-heroicon-o-pause-circle class="w-4 h-4 text-amber-600" />
                                Desactivar
                            @endif
                        </button>
                        <button wire:click="editar({{ $usuario->id }})" class="btn-secondary text-sm">
                            <x-heroicon-o-pencil class="w-4 h-4 text-orange-600" />
                            Editar
                        </button>
                    </div>
                </x-slot>

                {{-- Header --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center gap-4 pb-4 mb-4 border-b border-slate-100 dark:border-slate-700">
                    @php
                        $colors = ['bg-primary-500', 'bg-brand-500', 'bg-amber-500', 'bg-rose-500', 'bg-purple-500'];
                        $color = $colors[$usuario->id % count($colors)];
                    @endphp
                    <div class="avatar avatar-lg {{ $color }} shrink-0">
                        {{ strtoupper(substr($usuario->nombres, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-xl font-display font-semibold text-slate-900 dark:text-slate-100 truncate">
                            {{ $usuario->nombres }} {{ $usuario->apellidos }}
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $usuario->email }}</p>
                    </div>
                </div>

                {{-- Details --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Rol
                        </p>
                        <div class="mt-1">
                            @if ($usuario->role->nombre === 'Administrador')
                                <span class="badge-primary">Administrador</span>
                            @else
                                <span class="badge-pending">Empleado</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Estado</p>
                        <div class="mt-1">
                            @if ($usuario->estado)
                                <span class="badge-active">Activo</span>
                            @else
                                <span class="badge-inactive">Inactivo</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Registrado</p>
                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                            {{ $usuario->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </x-ui.section>

            @php
                $usuarioChartOptions = [
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
            <x-ui.section title="Estadísticas" description="Clientes y trámites de los últimos 6 meses">
                <div class="relative h-72">
                    <canvas id="usuarioChart" class="hidden sm:block w-full h-full"
                        data-chart='@json($chartData)'
                        data-chart-options='@json($usuarioChartOptions)'></canvas>
                    <div
                        class="flex sm:hidden items-center justify-center h-full text-sm text-slate-500 dark:text-slate-400">
                        <x-heroicon-o-device-phone-mobile class="w-5 h-5 mr-2" />
                        Amplía la ventana para ver la gráfica
                    </div>
                </div>
            </x-ui.section>

            {{-- Recent clients --}}
            <x-ui.section :padding="false">
                <x-slot name="title">Últimos clientes registrados</x-slot>
                <x-slot name="headerActions">
                    <a href="{{ route('clientes.index') }}" wire:navigate
                        class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                        Ver todos
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </x-slot>

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
                            @forelse ($usuario->clientes->sortByDesc('created_at')->take(5) as $cliente)
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
                                        {{ $cliente->dpi }}</td>
                                    <td class="table-cell text-center text-slate-600 dark:text-slate-400">
                                        {{ $cliente->email }}</td>
                                    <td class="table-cell text-center num text-slate-600 dark:text-slate-400">
                                        {{ $cliente->nit }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state py-8">
                                            <x-heroicon-o-users />
                                            <p>Sin clientes registrados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.section>

            {{-- Recent tramites --}}
            <x-ui.section :padding="false">
                <x-slot name="title">Últimos trámites realizados</x-slot>
                <x-slot name="headerActions">
                    <a href="{{ route('tramites.index') }}" wire:navigate
                        class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                        Ver todos
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </x-slot>

                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-full table-auto whitespace-nowrap">
                        <thead>
                            <tr>
                                <th class="table-header w-12">#</th>
                                <th class="table-header">Cliente</th>
                                <th class="table-header">Tipo de trámite</th>
                                <th class="table-header w-28">Precio</th>
                                <th class="table-header w-28">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse ($usuario->tramites->sortByDesc('created_at')->take(5) as $tramite)
                                <tr class="table-row">
                                    <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="table-cell font-medium text-slate-800 dark:text-slate-200">
                                        {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                                    </td>
                                    <td class="table-cell text-slate-600 dark:text-slate-300">
                                        {{ $tramite->tipoTramite->nombre }}
                                    </td>
                                    <td
                                        class="table-cell text-center num font-semibold text-slate-800 dark:text-slate-200">
                                        Q {{ number_format($tramite->precio, 2) }}
                                    </td>
                                    <td class="table-cell text-center num text-slate-500 dark:text-slate-400">
                                        {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state py-8">
                                            <x-heroicon-o-briefcase />
                                            <p>Sin trámites realizados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.section>

        </div>
    @else
        <div class="empty-state pt-24">
            <x-heroicon-o-lock-closed />
            <p class="font-medium text-slate-500 dark:text-slate-400">Acceso restringido</p>
        </div>
    @endif
</div>
