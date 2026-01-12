<div>
    @if (Auth::user()->role->nombre == 'Administrador')
        <h4 class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
            Tabla de roles
        </h4>

        <!-- Mostrar los roles -->
        <div class="w-full lg:w-3/4 overflow-hidden rounded-lg shadow-lg border mx-auto dark:border-gray-700">
            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-full table-auto whitespace-nowrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 w-2/12">No.</th>
                            <th class="px-4 py-3 w-5/12">Nombre</th>
                            <th class="px-4 py-3 w-2/12">Usuarios</th>
                            <th class="px-4 py-3 w-3/12">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($roles as $role)
                            <tr class="text-gray-700 dark:text-gray-400 text-center">
                                <td class="px-4 py-3 font-semibold w-2/12">{{ $role->id }}</td>
                                <td class="px-4 py-3 font-semibold w-5/12">{{ $role->nombre }}</td>
                                <td class="px-4 py-3 font-semibold w-2/12">{{ $role->users->count() }}</td>
                                <td class="px-4 py-3 w-3/12">
                                    <div class="flex items-center justify-center space-x-2 text-sm">
                                        <button title="Ver información del usuario"
                                            wire:click="verUsuarios({{ $role->id }})"
                                            class="flex justify-center items-center gap-2 font-semibold py-1 px-2 text-purple-600 rounded-lg focus:outline-none focus:shadow-outline-gray hover:border hover:border-purple-600 border border-transparent"
                                            aria-label="Ver">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span class="hidden md:block">Ver</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
