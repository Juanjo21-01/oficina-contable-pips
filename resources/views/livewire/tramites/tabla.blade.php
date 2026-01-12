<div>
    <!-- Título -->
    <h4 class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
        Tabla de Trámites
    </h4>

    <div
        class="w-full flex flex-col md:flex-row items-center justify-between gap-4 mb-4 space-y-2 sm:space-y-0 sm:space-x-4">
        <!-- Agregar trámite -->
        <a class="w-full md:w-6/12 flex items-center justify-center sm:justify-between p-4 font-semibold text-teal-100 bg-teal-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-teal cursor-pointer hover:bg-teal-700 transition-colors duration-150 border border-transparent"
            href="{{ route('tramites.crear') }}" wire:navigate>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="pl-4 pr-1">Agregar </span>
                <span class="hidden md:inline"> nuevo trámite</span>
            </div>
            <span class="hidden sm:inline">Vamos &RightArrow;</span>
        </a>

        <!-- Buscador y filtro -->
        <div
            class="w-full md:w-6/12 flex flex-col sm:flex-row items-center justify-end gap-2 mb-4 space-y-0 sm:space-x-4">
            <!-- Input de búsqueda -->
            <div class="w-full sm:w-6/12">
                <x-input-label for="search" :value="__('Buscar')" />
                <x-text-input wire:model.live.debounce.500ms="search" id="search" placeholder="......"
                    class="block w-full mt-1 px-3 py-1 " type="text" />
            </div>
            <!-- Filtros -->
            <div class="w-full sm:w-6/12 flex gap-4">
                <div class="w-8/12">
                    <x-input-label for="estado" :value="__('Estado')" />
                    <select wire:model.live="estado" id="estado"
                        class="block w-full mt-1 pl-3 pr-7 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>
                <div class="w-4/12">
                    <x-input-label for="perPage" :value="__('Mostrar')" />
                    <select wire:model.live="perPage" id="perPage"
                        class="block w-full mt-1 pl-3 pr-7 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de tramites -->
    <div class="w-full overflow-hidden rounded-lg shadow-lg border mx-auto dark:border-gray-700 mb-4">
        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 w-1/12">No.</th>
                        <th class="px-4 py-3 w-3/12">Cliente</th>
                        <th class="px-4 py-3 w-3/12">Tipo de trámite</th>
                        <th class="px-4 py-3 w-1/12">Precio</th>
                        <th class="px-4 py-3 w-1/12">Fecha</th>
                        <th class="px-4 py-3 w-1/12">Estado</th>
                        <th class="px-4 py-3 w-2/12">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($tramites->isEmpty())
                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                            <td class="px-4 py-3" colspan="7">No hay registros</td>
                        </tr>
                    @endif
                    @foreach ($tramites as $tramite)
                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                            <td class="px-4 py-3 font-semibold w-1/12">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 w-3/12">{{ $tramite->cliente->nombres }}
                                {{ $tramite->cliente->apellidos }} </td>
                            <td class="px-4 py-3 w-3/12">{{ $tramite->tipoTramite->nombre }}</td>
                            <td class="px-4 py-3 w-1/12">Q. {{ $tramite->precio }}</td>
                            <td class="px-4 py-3 font-semibold w-1/12">{{ date('d/m/Y', strtotime($tramite->fecha)) }}
                            </td>
                            <td class="px-4 py-3 w-1/12">
                                <button wire:click="cambiarEstado({{ $tramite->id }})"
                                    class="px-4 py-2 font-semibold leading-tight rounded-full {{ $tramite->estado == 1 ? 'bg-teal-100 dark:bg-teal-700 text-teal-700 dark:text-teal-100 ' : 'bg-rose-100 dark:bg-rose-700 text-rose-700 dark:text-rose-100' }}">
                                    {{ $tramite->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </button>
                            </td>
                            <td class="px-4 py-3 w-2/12">
                                <div class="flex items-center justify-center space-x-2 text-sm">
                                    <a title="Ver información del trámite"
                                        href="{{ route('tramites.mostrar', $tramite->id) }}" wire:navigate
                                        class="flex justify-center items-center gap-2 font-semibold py-1 px-2 text-purple-600 rounded-lg focus:outline-none focus:shadow-outline-gray hover:border hover:border-purple-600 border border-transparent"
                                        aria-label="Ver">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <button title="Editar el trámite" wire:click="editar({{ $tramite->id }})"
                                        class="py-1 px-2 text-orange-600 rounded-lg focus:outline-none focus:shadow-outline-gray hover:border hover:border-orange-600 border border-transparent"
                                        aria-label="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    @if (Auth::user()->role->nombre == 'Administrador')
                                        <button title="Eliminar el trámite"
                                            wire:click="modalEliminar({{ $tramite->id }})"
                                            class="py-1 px-2 text-rose-600 rounded-lg focus:outline-none focus:shadow-outline-gray hover:border hover:border-rose-600 border border-transparent"
                                            aria-label="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        {{ $tramites->links('livewire::custom-pagination') }}
    </div>

    <!-- Modal de eliminar -->
    @if ($abrirModal)
        <div
            class="fixed inset-0 z-30 flex items-center bg-black bg-opacity-50 sm:items-center sm:justify-center transition ease-out duration-150">
            <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg px-6 py-4 max-w-md m-2">
                <!-- Header -->
                <header class="flex justify-between px-6 py-3">
                    <p class="text-xl font-semibold text-rose-600 dark:text-rose-400">Eliminar Trámite No.
                        {{ $tramiteId }}</p>
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700  hover:border"
                        wire:click="cerrarModal" aria-label="close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                <hr class="border-gray-200 dark:border-gray-700">

                <!-- Contenido -->
                <div class="px-6 py-4">
                    <p class="text-gray-800 dark:text-white">
                        ¿Estás seguro de que deseas eliminar el trámite del cliente: <span
                            class="font-semibold text-rose-600 dark:text-rose-400">
                            {{ $clienteNombre }} </span> con el tipo de trámite: <span
                            class="font-semibold text-rose-600 dark:text-rose-400">
                            {{ $tipoTramiteNombre }}
                        </span>?
                    </p>

                    <!-- Formulario -->
                    <form wire:submit.prevent="eliminar" class="px-4 py-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Por favor ingresa tu contraseña para confirmar la eliminación.
                        </p>

                        <!-- Contraseña -->
                        <div class="mt-2">
                            <x-input-label for="password" :value="__('Contraseña')" class="sr-only" />
                            <x-text-input wire:model="password" id="password"
                                class="block w-full mt-1 px-3 py-1 {{ $errors->has('password') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                                type="password" name="password" wire:keydown="clearError('password')"
                                placeholder="Contraseña" />
                            @error('password')
                                <span class="text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div
                            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
                            <button wire:click="cerrarModal" type="button"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-rose-500 focus:border-rose-500 active:text-gray-500 focus:outline-none">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2  focus:outline-none bg-rose-600 active:bg-rose-600 hover:bg-rose-700">
                                Eliminar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    @endif
</div>
