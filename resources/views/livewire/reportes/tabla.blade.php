<div class="space-y-6">

    {{-- Tab pills --}}
    @php
        $tabs = ['semana' => 'Esta semana', 'mes' => 'Este mes', 'rango' => 'Rango personalizado'];
    @endphp
    <div class="flex items-center gap-1 p-1 bg-slate-100 dark:bg-slate-800 rounded-lg w-fit">
        @foreach ($tabs as $key => $label)
            <button wire:click="cambiarFiltro('{{ $key }}')"
                @class([
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none',
                    'bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 shadow-sm' => $filtrar === $key,
                    'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' => $filtrar !== $key,
                ])>
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- Date range picker --}}
    @if ($filtrar === 'rango')
        <x-ui.section title="Filtros del reporte">
            <form wire:submit.prevent="obtenerReportes" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.form-field label="Fecha inicial" for="rep-fechaInicio" required>
                        <input wire:model="fechaInicio" id="rep-fechaInicio" type="date"
                            class="form-input-base py-2 px-3" required />
                    </x-ui.form-field>
                    <x-ui.form-field label="Fecha final" for="rep-fechaFin" required>
                        <input wire:model="fechaFin" id="rep-fechaFin" type="date"
                            class="form-input-base py-2 px-3" required />
                    </x-ui.form-field>
                    <x-ui.form-field label="Tipo de trámite" for="rep-tipoTramite">
                        <select wire:model="tipoTramiteId" id="rep-tipoTramite" class="form-select-base py-2 px-3">
                            <option value="">Todos los tipos</option>
                            @foreach ($tiposTramites as $tipoTramite)
                                <option value="{{ $tipoTramite->id }}">{{ $tipoTramite->nombre }}</option>
                            @endforeach
                        </select>
                    </x-ui.form-field>
                    <x-ui.form-field label="Cliente" for="rep-cliente">
                        <select wire:model="clienteId" id="rep-cliente" class="form-select-base py-2 px-3">
                            <option value="">Todos los clientes</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </x-ui.form-field>
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" icon="magnifying-glass">
                        Generar reporte
                    </flux:button>
                </div>
            </form>
        </x-ui.section>
    @endif

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-ui.stat-card
            label="Total de trámites"
            :value="$totalTramites . ' ' . ($totalTramites === 1 ? 'trámite' : 'trámites')"
            icon="briefcase"
            color="primary" />
        <x-ui.stat-card
            label="Remanente total"
            :value="'Q ' . number_format($gastoTotal, 2)"
            icon="banknotes"
            color="brand" />
        <x-ui.stat-card
            label="Promedio de remanente"
            :value="'Q ' . number_format($promedioGasto, 2)"
            icon="calculator"
            color="amber" />
    </div>

    {{-- Table --}}
    <x-ui.section :padding="false">
        <x-slot name="title">{{ $tabs[$filtrar] ?? ucfirst($filtrar) }}</x-slot>
        <x-slot name="headerActions">
            @if ($filtrar === 'rango')
                <form action="{{ route('reportes.pdf', $filtrar) }}" method="GET">
                    <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
                    <input type="hidden" name="fechaFin" value="{{ $fechaFin }}">
                    <input type="hidden" name="tipoTramiteId" value="{{ $tipoTramiteId }}">
                    <input type="hidden" name="clienteId" value="{{ $clienteId }}">
                    <button type="submit" class="btn-secondary text-sm">
                        <x-heroicon-o-arrow-down-tray class="w-4 h-4 text-orange-600" />
                        Descargar PDF
                    </button>
                </form>
            @else
                <a href="{{ route('reportes.pdf', $filtrar) }}" class="btn-secondary text-sm">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4 text-orange-600" />
                    Descargar PDF
                </a>
            @endif
        </x-slot>

        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="table-header w-12">#</th>
                        <th class="table-header">Cliente</th>
                        <th class="table-header">Tipo de trámite</th>
                        <th class="table-header w-28">Fecha</th>
                        <th class="table-header w-28">Precio</th>
                        <th class="table-header w-28">Gastos</th>
                        <th class="table-header w-32">Remanente</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($reporte as $key => $tramite)
                        <tr class="table-row">
                            <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                {{ $key + 1 }}
                            </td>
                            <td class="table-cell font-medium text-slate-800 dark:text-slate-200">
                                {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                            </td>
                            <td class="table-cell text-slate-600 dark:text-slate-300">
                                {{ $tramite->tipoTramite->nombre }}
                            </td>
                            <td class="table-cell text-center num text-slate-500 dark:text-slate-400">
                                {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                            </td>
                            <td class="table-cell text-center num text-slate-700 dark:text-slate-300">
                                Q {{ number_format($tramite->precio, 2) }}
                            </td>
                            <td class="table-cell text-center num text-slate-700 dark:text-slate-300">
                                Q {{ number_format($tramite->gastos, 2) }}
                            </td>
                            <td class="table-cell text-center num font-semibold text-emerald-600 dark:text-emerald-400">
                                Q {{ number_format($tramite->precio - $tramite->gastos, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state py-8">
                                    <x-heroicon-o-document-chart-bar />
                                    <p>Sin trámites en este período</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.section>

</div>
