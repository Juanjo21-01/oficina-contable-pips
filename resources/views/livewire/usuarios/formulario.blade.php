<div>
    <form wire:submit.prevent="guardar">
        @if ($errorMessage)
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-sm">{{ $errorMessage }}</div>
        @endif

        <!-- Nombres -->
        <div class="mb-2">
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
        <div class="mb-2">
            <x-input-label for="apellidos" :value="__('Apellidos')" />
            <x-text-input wire:model="apellidos" id="apellidos"
                class="block w-full mt-1 px-3 py-1 {{ $errors->has('apellidos') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                type="text" name="apellidos" wire:keydown="clearError('apellidos')" />
            @error('apellidos')
                <span class="text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-2">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input wire:model="email" id="email"
                class="block w-full mt-1 px-3 py-1 {{ $errors->has('email') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                type="email" name="email" wire:keydown="clearError('email')" />
            @error('email')
                <span class="text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </span>
            @enderror
        </div>

        @if ($roleId != 1)
            <!-- Contraseña -->
            <div class="mb-2">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input wire:model="password" id="password"
                    class="block w-full mt-1 px-3 py-1 {{ $errors->has('password') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                    type="password" name="password" wire:keydown="clearError('password')" />
                @error('password')
                    <span class="text-sm text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Rol -->
            <div class="mb-2">
                <x-input-label for="role_id" :value="__('Rol')" />
                <select wire:model="roleId" id="role_id"
                    class="block w-full mt-1 px-3 py-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-teal-400 dark:focus:border-teal-600 focus:outline-none focus:shadow-outline-teal rounded-md shadow-sm form-select {{ $errors->has('roleId') ? 'border-red-600 focus:border-red-400  dark:border-red-400' : '' }}"
                    name="roleId" wire:click="clearError('roleId')">
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
                @error('roleId')
                    <span class="text-sm text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        @endif

        <!-- Botones -->
        <div
            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
            <button wire:click="cerrarModal" type="button"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-rose-500 focus:border-rose-500 active:text-gray-500 focus:outline-none">
                Cancelar
            </button>
            <button type="submit"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2  focus:outline-none {{ $usuarioId ? 'bg-amber-600 active:bg-amber-600 hover:bg-amber-700' : 'bg-teal-600 active:bg-teal-600 hover:bg-teal-700' }}">
                {{ isset($usuarioId) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
