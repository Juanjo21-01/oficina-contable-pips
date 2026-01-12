<x-app-layout meta-title="- Inicio">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Bienvenida -->
            <div
                class="bg-white rounded-lg shadow-md p-4 dark:bg-gray-800 border-2 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-teal-600 dark:text-teal-400">¿Qué quieres hacer?</h3>
                    <p class="text-gray-600 dark:text-gray-400">Selecciona una de las opciones a continuación para
                        comenzar a trabajar.</p>
                </div>
                <!-- Reloj -->
                <div class="mt-4 flex items-center justify-center">
                    <div class="text-center">
                        <p id="current-time" class="text-2xl font-bold text-teal-600 dark:text-teal-400"></p>
                        <p id="current-date" class="text-lg font-semibold text-gray-700 dark:text-gray-300"></p>
                    </div>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('tramites.crear') }}" wire:navigate
                    class="bg-teal-600 text-white rounded-lg shadow-md p-4 flex items-center justify-between hover:bg-teal-700 ">
                    <div>
                        <h3 class="text-2xl font-semibold">Agregar Trámite</h3>
                        <p class="text-gray-200">Registrar un nuevo trámite</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
                <a href="{{ route('clientes.crear') }}" wire:navigate
                    class="bg-teal-600 text-white rounded-lg shadow-md p-4 flex items-center justify-between hover:bg-teal-700">
                    <div>
                        <h3 class="text-2xl font-semibold">Agregar Cliente</h3>
                        <p class="text-gray-200">Registrar un nuevo cliente</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
                <a href="{{ route('reportes.index') }}" wire:navigate
                    class="bg-teal-600 text-white rounded-lg shadow-md p-4 flex items-center justify-between hover:bg-teal-700">
                    <div>
                        <h3 class="text-2xl font-semibold">Ver Reportes</h3>
                        <p class="text-gray-200">Consultar reportes de trámites</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                    </svg>

                </a>
            </div>

            <!-- Resumen de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 {{Auth::user()->role->nombre == 'Administrador' ? 'lg:grid-cols-3' : ''}}">
                <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 border-2 dark:border-gray-700">
                    <div
                        class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
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
                <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 border-2 dark:border-gray-700">
                    <div class="p-3 mr-4 text-rose-500 bg-rose-100 rounded-full dark:text-rose-100 dark:bg-rose-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total de Clientes
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalClientes }} {{ $totalClientes === 1 ? 'Cliente' : 'Clientes' }}
                        </p>
                    </div>
                </div>
                @if (Auth::user()->role->nombre == 'Administrador')
                    <div
                        class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 border-2 dark:border-gray-700">
                        <div
                            class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Honorarios Totales del Mes
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                Q. {{ number_format($gastoTotal, 2) }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Estadísticas -->
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

            <!-- Últimos Registros -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Últimos Trámites -->
                <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gray-800 border-2 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400">Últimos Trámites</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach ($ultimosTramites as $tramite)
                            <li class="flex justify-between text-gray-700 dark:text-gray-300">
                                <div>
                                    <p class="font-semibold">{{ $tramite->cliente->nombres }}
                                        {{ $tramite->cliente->apellidos }}</p>
                                    <p class="text-sm">{{ $tramite->tipoTramite->nombre }}</p>
                                    <p class="text-sm">{{ date('d/m/Y', strtotime($tramite->fecha)) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">Q{{ number_format($tramite->precio, 2) }}</p>
                                    <p
                                        class="px-2 py-1 rounded-full text-sm font-semibold {{ $tramite->estado ? 'bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100 ' : 'bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100' }}">
                                        {{ $tramite->estado ? 'Activo' : 'Inactivo' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Últimos Clientes -->
                <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gray-800 border-2 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400">Últimos Clientes</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach ($ultimosClientes as $cliente)
                            <li class="flex justify-between text-gray-700 dark:text-gray-300">
                                <div>
                                    <p class="font-semibold">{{ $cliente->nombres }} {{ $cliente->apellidos }}</p>
                                    <p class="text-sm">{{ $cliente->email }}</p>
                                    <p class="text-sm">{{ $cliente->telefono }}</p>
                                </div>
                                <div class="text-right">
                                    <p
                                        class="px-2 py-1 rounded-full text-sm font-semibold {{ $cliente->estado ? 'bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100 ' : 'bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100' }}">
                                        {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para inicializar Chart.js -->
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

    <!-- Script para actualizar la hora -->
    <script>
        function updateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const time = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const dateElement = document.getElementById('current-date');
            const timeElement = document.getElementById('current-time');

            if (dateElement && timeElement) {
                dateElement.textContent = date;
                timeElement.textContent = time;
            }
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</x-app-layout>
