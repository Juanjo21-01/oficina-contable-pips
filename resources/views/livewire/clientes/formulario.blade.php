<div>
    <form class="mb-16">
        @if ($errorMessage)
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-sm">{{ $errorMessage }}</div>
        @endif

        <!-- Tarjeta de Información Principal -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md pt-3 pb-4 px-6 mb-4 border-2 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 mb-4 text-center">Información Principal
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nombres -->
                <div>
                    <x-input-label for="nombres" :value="__('Nombres')" />
                    <x-text-input wire:model="nombres" id="nombres"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('nombres') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="nombres" autofocus wire:keydown="clearError('nombres')" />
                    @error('nombres')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Apellidos -->
                <div>
                    <x-input-label for="apellidos" :value="__('Apellidos')" />
                    <x-text-input wire:model="apellidos" id="apellidos"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('apellidos') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="apellidos" wire:keydown="clearError('apellidos')" />
                    @error('apellidos')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Dirección -->
                <div>
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input wire:model="direccion" id="direccion"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('direccion') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="direccion" wire:keydown="clearError('direccion')" />
                    @error('direccion')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input wire:model="telefono" id="telefono"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('telefono') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="telefono" wire:keydown="clearError('telefono')" />
                    @error('telefono')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tarjeta de Datos Fiscales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md pt-3 pb-4 px-6 mb-4 border-2 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 mb-4 text-center">Datos Fiscales</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- DPI -->
                <div>
                    <x-input-label for="dpi" :value="__('DPI')" />
                    <x-text-input wire:model="dpi" id="dpi"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('dpi') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="dpi" wire:keydown="clearError('dpi')" />
                    @error('dpi')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- NIT -->
                <div>
                    <x-input-label for="nit" :value="__('NIT')" />
                    <x-text-input wire:model="nit" id="nit"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('nit') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="text" name="nit" wire:keydown="clearError('nit')" />
                    @error('nit')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Tipo de Cliente -->
                <div>
                    <x-input-label for="tipo_cliente_id" :value="__('Tipo de Cliente')" />
                    <select wire:model="tipoClienteId" id="tipo_cliente_id"
                        class="block w-full mt-1 px-3 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select {{ $errors->has('tipoClienteId') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        name="tipoClienteId" wire:click="clearError('tipoClienteId')">
                        <option value="">Seleccione un tipo de cliente</option>
                        @foreach ($tipoClientes as $tipoCliente)
                            <option value="{{ $tipoCliente->id }}">{{ $tipoCliente->nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipoClienteId')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input wire:model="email" id="email"
                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('email') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                        type="email" name="email" wire:keydown="clearError('email')" />
                    @error('email')
                        <span class="text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <!-- Botones -->
        <div
            class="flex flex-col items-center text-center justify-center p-6 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
            <a type="button" href="{{ route('clientes.index') }}"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-8 sm:py-3 sm:w-auto active:bg-transparent hover:border-rose-500 focus:border-rose-500 active:text-gray-500 focus:outline-none">
                Cancelar
            </a>
            <button type="button" wire:click="abrirAgencia"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-8 sm:py-3 focus:outline-none bg-teal-600 active:bg-teal-600 hover:bg-teal-700">
                Guardar
            </button>
        </div>
    </form>

    <!-- Modal para agregar  -->
    @if ($abrirModalAgencia)
        <div
            class="fixed inset-0 z-30 flex items-center bg-black bg-opacity-50 sm:items-center sm:justify-center transition ease-out duration-150">
            <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg px-6 py-4 max-w-md m-2">
                <!-- Header -->
                <header class="flex justify-between px-6 py-3">
                    <p class="text-xl font-semibold text-teal-600 dark:text-teal-400">Agencia Virtual de:
                        {{ $nombres }}</p>
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700 hover:border"
                        wire:click="cerrarModalAgencia" aria-label="close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                <hr class="border-gray-200 dark:border-gray-700">

                <div class="px-6 py-4">
                    <!-- Pregunta -->
                    @if (!$mostrarFormularioAgencia)
                        <p class="text-gray-800 dark:text-white text-center">
                            ¿Deseas agregar la agencia virtual para este cliente o solo deseas crear el cliente?
                        </p>

                        <div
                            class="flex flex-col items-center justify-center px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
                            <!-- Solo Crear Cliente -->
                            <button wire:click="guardar" type="button"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-teal-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-teal-500 focus:border-teal-500 active:text-gray-500 focus:outline-none">
                                Solo Crear Cliente
                            </button>

                            <!-- Agregar Agencia Virtual -->
                            <button wire:click="abrirFormularioAgencia" type="button"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 focus:outline-none bg-indigo-600 active:bg-indigo-600 hover:bg-indigo-700">
                                Agregar Agencia
                            </button>
                        </div>
                    @endif

                    <!-- Formulario para agregar Agencia Virtual -->
                    @if ($mostrarFormularioAgencia)
                        <div class="mt-4">
                            <form wire:submit.prevent="agregarAgenciaVirtual">

                                <!-- Correo Electrónico -->
                                <div class="mb-2">
                                    <x-input-label for="correo" :value="__('Correo Electrónico')" />
                                    <x-text-input wire:model="correo" id="correo"
                                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('correo') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                                        type="email" name="correo" autofocus
                                        wire:keydown="clearError('correo')" />
                                    @error('correo')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-2">
                                    <x-input-label for="contrasenia" :value="__('Contraseña')" />
                                    <x-text-input wire:model="contrasenia" id="contrasenia"
                                        class="block w-full mt-1 px-3 py-1 {{ $errors->has('contrasenia') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                                        type="password" name="contrasenia"
                                        wire:keydown="clearError('contrasenia')" />
                                    @error('contrasenia')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Observaciones -->
                                <div class="mb-2">
                                    <x-input-label for="observaciones" :value="__('Observaciones (Opcional)')" />
                                    <textarea wire:model="observaciones" id="observaciones"
                                        class="block w-full mt-1 px-3 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-textarea {{ $errors->has('observaciones') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                                        name="observaciones" wire:keydown="clearError('observaciones')"></textarea>
                                    @error('observaciones')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Botones del Formulario -->
                                <div
                                    class="flex flex-col items-center justify-center px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
                                    <button wire:click="cerrarModalAgencia" type="button"
                                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-teal-500 focus:border-teal-500 active:text-gray-500 focus:outline-none">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 focus:outline-none bg-teal-600 active:bg-teal-600 hover:bg-teal-700">
                                        Guardar Usuario y Agencia
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
