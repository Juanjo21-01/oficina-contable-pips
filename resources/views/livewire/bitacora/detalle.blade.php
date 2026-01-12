<div class="p-6 space-y-5">
    <!-- Tarjeta de la bitacora -->
    <div class="flex flex-col gap-4 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700">
        <div class="flex items-center justify-between border-b pb-4">
            <h2 class="text-xl font-bold text-teal-600 dark:text-teal-400">
                {{ $bitacora->user->nombres }} {{ $bitacora->user->apellidos }}
            </h2>
            <span class="text-base text-gray-500 dark:text-gray-400">
                {{ date('d/m/Y H:i:s', strtotime($bitacora->created_at)) }}
            </span>
        </div>

        <!-- Detalles -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex flex-col items-center sm:items-start gap-3">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Evento</p>
                <p class="text-base font-semibold text-gray-800 dark:text-gray-200 capitalize">
                    <span
                        class="px-4 py-2 text-sm font-semibold leading-tight rounded-full
                                    @if ($bitacora->tipo == 'creacion') bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100
                                    @elseif ($bitacora->tipo == 'eliminacion')
                                        bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100
                                    @elseif ($bitacora->tipo == 'reporte')
                                        bg-yellow-100 dark:bg-yellow-700 text-yellow-700 dark:text-yellow-100 @endif">
                        @if ($bitacora->tipo == 'creacion')
                            Creación
                        @elseif ($bitacora->tipo == 'eliminacion')
                            Eliminación
                        @elseif ($bitacora->tipo == 'reporte')
                            Reporte
                        @endif
                    </span>
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</p>
                <p class="text-base text-gray-800 dark:text-gray-200">
                    {{ $bitacora->descripcion }}
                </p>
            </div>
        </div>
    </div>
</div>
