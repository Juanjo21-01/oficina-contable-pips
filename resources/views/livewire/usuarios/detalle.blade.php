<div>
    @if (Auth::user()->role->nombre == 'Administrador')
        <div class="p-6 space-y-8">
            <!-- Tarjeta de perfil del usuario -->
            <div
                class="flex flex-col gap-4 p-6 bg-white dark:bg-gray-800 border rounded-lg shadow-md dark:border-gray-700">
                <!-- Encabezado -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-center border-b pb-4 dark:border-gray-600">
                    <h2 class="text-xl font-bold text-teal-600 dark:text-teal-400 mb-2 sm:mb-0">
                        {{ $usuario->nombres }} {{ $usuario->apellidos }}
                    </h2>
                    <span class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                        {{ $usuario->email }}
                    </span>
                </div>

                <!-- Detalles -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rol</p>
                        <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
                            {{ $usuario->role->nombre }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</p>
                        <p
                            class="text-base font-semibold {{ $usuario->estado ? 'text-teal-500 dark:text-teal-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                        </p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-2 pt-4 border-t dark:border-gray-600">
                    <button wire:click="cambiarEstado({{ $usuario->id }})"
                        class="px-4 py-2 text-sm font-medium leading-tight rounded-full {{ !$usuario->estado ? 'bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100 ' : 'bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100' }} {{ $usuario->role->nombre == 'Administrador' ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}">
                        {{ !$usuario->estado ? 'Activar' : 'Desactivar' }}
                    </button>

                    <button title="Editar el usuario" wire:click="editar({{ $usuario->id }})"
                        class="px-4 py-2 text-sm font-medium text-orange-600 rounded-lg border border-transparent hover:border-orange-600 flex items-center gap-2">
                        <span class="hidden sm:inline">Editar</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                    </button>
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

            <!-- Tabla de Clientes Relacionados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border-2 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 p-2">Últimos Clientes
                        <span class="hidden sm:inline">Registrados</span>

                    </h3>
                    {{-- boton para visitar la pagina de clientes --}}
                    <div class="flex justify-end">
                        <a href="{{ route('clientes.index') }}" wire:navigate
                            class="flex items-center text-teal-600 dark:text-teal-400 hover:underline">
                            <span>Ver todos los clientes</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
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
                                    class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3 w-1/12">No.</th>
                                    <th class="px-4 py-3 w-4/12">Nombres</th>
                                    <th class="px-4 py-3 w-2/12">DPI</th>
                                    <th class="px-4 py-3 w-3/12">Correo</th>
                                    <th class="px-4 py-3 w-2/12">NIT</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @if ($usuario->clientes->isEmpty())
                                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                                        <td class="px-4 py-3" colspan="5">No hay registros</td>
                                    </tr>
                                @endif
                                @foreach ($usuario->clientes->sortByDesc('created_at')->take(5) as $cliente)
                                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                                        <td class="px-4 py-3 w-1/12 font-semibold">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 w-4/12">
                                            <p class="font-semibold">{{ $cliente->nombres }} {{ $cliente->apellidos }}
                                            </p>
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

            <!-- Tabla de Trámites Relacionados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border-2 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 p-2">Últimos Trámites
                        <span class="hidden sm:inline">Realizados</span>
                    </h3>
                    {{-- boton para visitar la pagina de tramites --}}
                    <div class="flex justify-end">
                        <a href="{{ route('tramites.index') }}" wire:navigate
                            class="flex items-center text-teal-600 dark:text-teal-400 hover:underline">
                            <span>Ver todos los trámites</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
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
                                    class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3 w-1/12">No.</th>
                                    <th class="px-4 py-3 w-4/12">Cliente</th>
                                    <th class="px-4 py-3 w-3/12">Tipo de trámite</th>
                                    <th class="px-4 py-3 w-2/12">Precio</th>
                                    <th class="px-4 py-3 w-2/12">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @if ($usuario->tramites->isEmpty())
                                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                                        <td class="px-4 py-3" colspan="5">No hay registros</td>
                                    </tr>
                                @endif
                                @foreach ($usuario->tramites->sortByDesc('created_at')->take(5) as $tramite)
                                    <tr class="text-gray-700 dark:text-gray-400 text-center">
                                        <td class="px-4 py-3 font-semibold w-1/12">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 w-4/12">{{ $tramite->cliente->nombres }}
                                            {{ $tramite->cliente->apellidos }} </td>
                                        <td class="px-4 py-3 w-3/12">{{ $tramite->tipoTramite->nombre }}</td>
                                        <td class="px-4 py-3 w-2/12">Q. {{ $tramite->precio }}</td>
                                        <td class="px-4 py-3 font-semibold w-2/12">
                                            {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                            text: 'Cantidad de Clientes y Trámites de los últimos 6 meses'
                        }
                    }
                }
            });
        });
    </script>
</div>
