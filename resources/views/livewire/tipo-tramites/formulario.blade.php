<div>
    <form wire:submit.prevent="guardar">
        @if ($errorMessage)
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-sm">{{ $errorMessage }}</div>
        @endif

        <!-- Nombre -->
        <div class="mb-2">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input wire:model="nombre" id="nombre"
                class="block w-full mt-1 px-3 py-1 {{ $errors->has('nombre') ? 'border-red-600 focus:border-red-400 dark:border-red-400' : '' }}"
                type="text" name="nombre" autofocus wire:keydown="clearError('nombre')" />
            @error('nombre')
                <span class="text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Botones -->
        <div
            class="flex flex-col items-center justify-center px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
            <button wire:click="cerrarModal" type="button"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-rose-500 focus:border-rose-500 active:text-gray-500 focus:outline-none">
                Cancelar
            </button>
            <button type="submit"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2  focus:outline-none {{ $tipoTramiteId ? 'bg-amber-600 active:bg-amber-600 hover:bg-amber-700' : 'bg-teal-600 active:bg-teal-600 hover:bg-teal-700' }}">
                {{ isset($tipoTramiteId) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
