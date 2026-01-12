<div>
    <div class="p-6 space-y-5">
        <!-- Tarjeta de perfil del tramite -->
        <div class="flex flex-col gap-4 p-6 bg-white dark:bg-gray-800 border rounded-lg shadow-md dark:border-gray-700">
            <!-- Encabezado -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-center border-b pb-4 dark:border-gray-600">
                <h2 class="text-xl font-bold text-teal-600 dark:text-teal-400 mb-2 sm:mb-0">
                    {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                </h2>
                <span class="text-sm sm:text-base text-gray-500 dark:text-gray-400 font-semibold">
                    {{ $tramite->tipoTramite->nombre }}
                </span>
            </div>

            <!-- Detalles del trámite -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha del Trámite</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
                        {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Gastos</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
                        Q.{{ $tramite->gastos }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
                        Q.{{ $tramite->precio }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</p>
                    <p
                        class="text-base font-semibold {{ $tramite->estado ? 'text-teal-500 dark:text-teal-400' : 'text-rose-500 dark:text-rose-400' }}">
                        {{ $tramite->estado ? 'Activo' : 'Inactivo' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Observaciones</p>
                    <p class="text-base text-gray-800 dark:text-gray-200">
                        {{ $tramite->observaciones ?? 'Sin observaciones' }}
                    </p>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end gap-2 pt-4 border-t dark:border-gray-600">
                <button wire:click="cambiarEstado({{ $tramite->id }})"
                    class="px-4 py-2 text-sm font-medium leading-tight rounded-full {{ !$tramite->estado ? 'bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100' : 'bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100' }}">
                    {{ !$tramite->estado ? 'Activar' : 'Desactivar' }}
                </button>

                <button title="Editar el trámite" wire:click="editar({{ $tramite->id }})"
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

        <hr class="border-t dark:border-gray-700">

        <!-- Recibo del tramite -->
        <div class="flex justify-center mt-4">
            <a title="Descargar recibo" href="{{ route('tramites.pdf', $tramite->id) }}" target="_blank"
                rel="noopener noreferrer"
                class="px-4 py-2 text-sm font-medium text-orange-600 rounded-lg border border-transparent hover:border-orange-600 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
                <span>Descargar Recibo</span>
            </a>
        </div>

        <hr class="border-t dark:border-gray-700">

        <div
            class="w-full md:w-10/12 lg:w-8/12 xl:w-6/12 mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border-2 dark:border-gray-700">
            <!-- Encabezado con Logo e Información de la Empresa -->
            <div class="text-center border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
                <!-- Logo de la Empresa -->
                <img src="{{ asset('img/logo.png') }}" alt="Logo de la Empresa" class="mx-auto h-16 mb-2">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Recibo de Trámite</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Empresa Asesoría Fiscal Contable</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Dirección: 10 calle 7-37, Local #3, Zona 1, San Marcos
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono: (502) 5164-4661</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha: {{ date('d/m/Y') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Recibo No: #{{ $tramite->id }}</p>
            </div>

            <!-- Información del Cliente -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Información del Cliente</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Nombre: {{ $tramite->cliente->nombres }}
                    {{ $tramite->cliente->apellidos }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Dirección: {{ $tramite->cliente->direccion }} </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono: {{ $tramite->cliente->telefono }} </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">NIT: {{ $tramite->cliente->nit }}</p>
            </div>

            <!-- Detalles del Trámite -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Detalles del Trámite</h3>
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Concepto:</span>
                    <span>{{ $tramite->observaciones }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Fecha de Servicio:</span>
                    <span>{{ date('d/m/Y', strtotime($tramite->fecha)) }}</span>
                </div>
            </div>

            <!-- Tabla de Servicios -->
            <div class="mb-2">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Detalle de Servicios</h3>
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead>
                        <tr>
                            <th class="border-b py-2 border-gray-200 dark:border-gray-700">Descripción</th>
                            <th class="border-b py-2 text-right border-gray-200 dark:border-gray-700">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2">{{ $tramite->tipoTramite->nombre }}</td>
                            <td class="py-2 text-right">Q. {{ number_format($tramite->precio, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Gastos -->
            <div class="flex justify-between items-center mb-4 text-rose-700 dark:text-rose-400 text-base">
                <span>Gastos</span>
                <span> - Q. {{ number_format($tramite->gastos, 2) }}</span>
            </div>

            <!-- Total -->
            <div class="border-t pt-4 border-gray-200 dark:border-gray-700">
                <div class="flex justify-between font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    <span>Total Remanente</span>
                    <span>Q. {{ number_format($tramite->precio - $tramite->gastos, 2) }}</span>
                </div>
            </div>

            <!-- Firma -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">Firma del Cliente</p>
                <div class="border-t border-gray-400 dark:border-gray-600 mt-2 w-1/2 mx-auto"></div>
            </div>
        </div>
    </div>
</div>
