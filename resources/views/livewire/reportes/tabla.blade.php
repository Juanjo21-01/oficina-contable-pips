<div>
    <!-- Indicadores -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total de Trámites
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $totalTramites }} {{ $totalTramites === 1 ? 'Trámite' : 'Trámites' }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Remanente Total
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    Q. {{ number_format($gastoTotal, 2) }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Promedio de Remanente
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    Q. {{ number_format($promedioGasto, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Formulario de selección de rango de fechas -->
    @if ($filtrar === 'rango')
        <form wire:submit.prevent="obtenerReportes" class="mb-6 flex flex-col justify-center items-center gap-5">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Rango de fechas --}}
                <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
                    <div class="w-full sm:w-6/12">
                        <x-input-label for="fechaInicio" :value="__('Fecha Inicial')" />
                        <x-text-input wire:model="fechaInicio" id="fechaInicio" class="block w-full mt-1 px-3 py-1"
                            type="date" name="fechaInicio" required />
                    </div>
                    <div class="w-full sm:w-6/12">
                        <x-input-label for="fechaFin" :value="__('Fecha Final')" />
                        <x-text-input wire:model="fechaFin" id="fechaFin" class="block w-full mt-1 px-3 py-1"
                            type="date" name="fechaFin" required />
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
                    <div class="w-full sm:w-6/12">
                        <x-input-label for="tipo_tramite_id" :value="__('Tipo de Trámite')" />
                        <select wire:model="tipoTramiteId" id="tipo_tramite_id"
                            class="block w-full mt-1 px-3 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select"
                            name="tipoTramiteId">
                            <option value="">Todos</option>
                            @foreach ($tiposTramites as $tipoTramite)
                                <option value="{{ $tipoTramite->id }}">{{ $tipoTramite->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-6/12">
                        <x-input-label for="cliente_id" :value="__('Cliente')" />
                        <select wire:model="clienteId" id="cliente_id"
                            class="block w-full mt-1 px-3 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select"
                            name="clienteId">
                            <option value="">Todos</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombres }}
                                    {{ $cliente->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto focus:outline-none bg-teal-600 active:bg-teal-600 hover:bg-teal-700">
                Generar Reporte
            </button>
        </form>
    @endif

    <div class="w-full mx-auto flex items-center justify-between mb-4">
        <!-- Título -->
        <h4 class="p-2 text-xl font-semibold text-gray-600 dark:text-gray-300">
            Tabla de Trámites por {{ ucfirst($filtrar) }}
        </h4>
        <!-- Reporte de los trámites -->
        @if ($filtrar === 'rango')
            <form action="{{ route('reportes.pdf', $filtrar) }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="fechaInicio" value="{{ $fechaInicio }}">
                <input type="hidden" name="fechaFin" value="{{ $fechaFin }}">
                <input type="hidden" name="tipoTramiteId" value="{{ $tipoTramiteId }}">
                <input type="hidden" name="clienteId" value="{{ $clienteId }}">
                <button type="submit" title="Descargar el reporte"
                    class="px-4 py-2 text-orange-600 dark:text-orange-400 rounded-lg focus:outline-none hover:border hover:border-orange-600 border border-transparent flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    <span class="hidden sm:inline">Descargar Reporte</span>
                </button>
            </form>
        @else
            <a title="Descargar el reporte" href="{{ route('reportes.pdf', $filtrar) }}"
                class="px-4 py-2 text-orange-600 dark:text-orange-400 rounded-lg focus:outline-none hover:border hover:border-orange-600 border border-transparent flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
                <span class="hidden sm:inline">Descargar Reporte</span>
            </a>
        @endif
    </div>

    <!-- Tabla de tramites -->
    <div class="w-full overflow-x-auto rounded-lg shadow-lg border mx-auto dark:border-gray-700 mb-5">
        <table class="min-w-full whitespace-nowrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3 w-1/12">No.</th>
                    <th class="px-4 py-3 w-3/12">Cliente</th>
                    <th class="px-4 py-3 w-3/12">Tipo de trámite</th>
                    <th class="px-4 py-3 w-2/12">Fecha</th>
                    <th class="px-4 py-3 w-1/12">Precio</th>
                    <th class="px-4 py-3 w-1/12">Gastos</th>
                    <th class="px-4 py-3 w-1/12">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @forelse ($reporte as $key => $tramite)
                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                        <td class="px-4 py-3 font-semibold w-1/12">{{ $key + 1 }}</td>
                        <td class="px-4 py-3 w-3/12">{{ $tramite->cliente->nombres }}
                            {{ $tramite->cliente->apellidos }}</td>
                        <td class="px-4 py-3 w-3/12">{{ $tramite->tipoTramite->nombre }}</td>
                        <td class="px-4 py-3 font-semibold w-2/12">{{ date('d/m/Y', strtotime($tramite->fecha)) }}
                        </td>
                        <td class="px-4 py-3 w-1/12">Q{{ number_format($tramite->precio, 2) }}</td>
                        <td class="px-4 py-3 w-1/12">Q{{ number_format($tramite->gastos, 2) }}</td>
                        <td class="px-4 py-3 font-semibold w-1/12">
                            Q{{ number_format($tramite->precio - $tramite->gastos, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                        <td class="px-4 py-3" colspan="7">No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación -->
        {{-- <div class="mt-4">
            {{ $reporte->links() }}
        </div> --}}
    </div>
</div>
