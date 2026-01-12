<div>
    <div class="p-6 space-y-8">
        <!-- Tarjeta de perfil del tipo de cliente -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700">
            <h2
                class="text-center sm:text-start text-2xl font-bold text-teal-600 dark:text-teal-400 mb-2 border-b pb-4 dark:border-gray-600">
                {{ $tipoCliente->nombre }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Fecha de Creación:</strong> {{ $tipoCliente->created_at->format('d/m/Y') }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Clientes Asociados:</strong> {{ $tipoCliente->clientes->count() }}
                    {{ $tipoCliente->clientes->count() == 1 ? 'cliente' : 'clientes' }}
                </p>
            </div>
        </div>

        <!-- Espacio para estadísticas -->
        <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gray-800 border-2 dark:border-gray-700">
            <h3 class="text-2xl font-semibold text-teal-600 dark:text-teal-400 mb-2">Estadísticas</h3>
            <div class="w-full h-96 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="w-full h-full items-center justify-center hidden sm:flex">
                    <canvas id="myChart" class="w-full h-full "></canvas>
                </div>
                <span class=" text-gray-500 dark:text-gray-300 text-center inline sm:hidden">Por favor, amplía la
                    ventana para ver la gráfica</span>
            </div>
        </div>

        <!-- Tabla de Clientes Asociados -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border-2 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 p-2">Últimos Clientes
                    <span class="hidden sm:inline">Asociados</span>
                </h3>
                {{-- Botón para visitar la página de clientes --}}
                <div class="flex justify-end">
                    <a href="{{ route('clientes.index') }}" wire:navigate
                        class="flex items-center text-teal-600 dark:text-teal-400 hover:underline">
                        <span>Ver todos los clientes</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="w-full overflow-hidden rounded-lg shadow-lg border mx-auto dark:border-gray-700 mb-4">
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-widest text-center text-gray-500 dark:text-gray-400 uppercase border-b-2 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-4 py-3 w-1/12">No.</th>
                                <th class="px-4 py-3 w-4/12">Nombres</th>
                                <th class="px-4 py-3 w-2/12">DPI</th>
                                <th class="px-4 py-3 w-3/12">Correo</th>
                                <th class="px-4 py-3 w-2/12">NIT</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @if ($tipoCliente->clientes->isEmpty())
                                <tr class="text-gray-700 dark:text-gray-400 text-center">
                                    <td class="px-4 py-3" colspan="5">No hay registros</td>
                                </tr>
                            @endif
                            @foreach ($tipoCliente->clientes->sortByDesc('created_at')->take(5) as $cliente)
                                <tr class="text-gray-700 dark:text-gray-300 text-center">
                                    <td class="px-4 py-3 w-1/12 font-semibold">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 w-4/12">
                                        <p class="font-semibold">{{ $cliente->nombres }} {{ $cliente->apellidos }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ $cliente->direccion }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-3 w-2/12">{{ $cliente->dpi }}</td>
                                    <td class="px-4 py-3 w-3/12">{{ $cliente->email }}</td>
                                    <td class="px-4 py-3 w-2/12">{{ $cliente->nit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('myChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Cantidad de Clientes de los últimos 6 meses'
                        }
                    }
                }
            });
        });
    </script>
</div>
