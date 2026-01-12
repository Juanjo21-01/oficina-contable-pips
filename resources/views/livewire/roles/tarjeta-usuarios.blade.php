<div class="py-5 w-full lg:w-3/4 mx-auto overflow-hidden">
    @if ($verUsuarios)
        <div class="overflow-x-auto rounded-lg p-2">
            {{-- cerrar ventana --}}
            <div class="flex justify-end px-4">
                <button wire:click="cerrarUsuarios" title="Cerrar"
                    class="p-1 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm-1-9a1 1 0 112 0v3a1 1 0 11-2 0V7zm0 5a1 1 0 011-1h.5a1 1 0 110 2h-.5a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="grid md:grid-cols-1 xl:grid-cols-2">
                @foreach ($usuarios as $usuario)
                    <div
                        class="flex justify-between p-4 m-3 bg-white rounded-lg dark:bg-gray-800 shadow-lg border dark:border-gray-700">
                        <div class="flex items-center">
                            <div
                                class="p-3 mr-4  rounded-full {{ $usuario->estado ? 'text-green-500 bg-green-100 dark:text-green-100 dark:bg-green-500' : 'text-rose-500 bg-rose-100 dark:text-rose-100 dark:bg-rose-500' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ $usuario->email }}
                                </p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $usuario->nombres }} {{ $usuario->apellidos }}
                                </p>
                            </div>
                        </div>
                        {{-- redireccionar a la vista de usuario --}}
                        <div class="flex justify-center items-center space-x-1 ">
                            <a title="Ver información del usuario" href="{{ route('usuarios.mostrar', $usuario) }}"
                                wire:navigate
                                class="py-1 px-2 text-purple-600 rounded-lg focus:outline-none focus:shadow-outline-gray hover:border hover:border-purple-600 border border-transparent"
                                aria-label="Ver">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
