<div>
    <form wire:submit.prevent="guardar" id="usuario-form" autocomplete="off" class="space-y-4">

        @if ($errorMessage)
            <div class="flex items-center gap-2 px-4 py-3 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                {{ $errorMessage }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-ui.form-field label="Nombres" for="usr-nombres" required :error="$errors->first('nombres')">
                <input wire:model="nombres" id="usr-nombres" type="text"
                    class="form-input-base py-2 px-3 {{ $errors->has('nombres') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                    wire:keydown="clearError('nombres')" autofocus />
            </x-ui.form-field>

            <x-ui.form-field label="Apellidos" for="usr-apellidos" required :error="$errors->first('apellidos')">
                <input wire:model="apellidos" id="usr-apellidos" type="text"
                    class="form-input-base py-2 px-3 {{ $errors->has('apellidos') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                    wire:keydown="clearError('apellidos')" />
            </x-ui.form-field>

            <x-ui.form-field label="Correo electrónico" for="usr-email" required :error="$errors->first('email')"
                class="sm:col-span-2">
                <input wire:model="email" id="usr-email" type="email"
                    class="form-input-base py-2 px-3 {{ $errors->has('email') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                    wire:keydown="clearError('email')" />
            </x-ui.form-field>

            @if ($roleId != 1)
                <x-ui.form-field label="Contraseña" for="usr-password"
                    :helper="$usuarioId ? 'Dejar vacío para no cambiar' : null"
                    :required="!$usuarioId"
                    :error="$errors->first('password')">
                    <input wire:model="password" id="usr-password" type="password"
                        class="form-input-base py-2 px-3 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:keydown="clearError('password')" />
                </x-ui.form-field>

                <x-ui.form-field label="Rol" for="usr-role" required :error="$errors->first('roleId')">
                    <select wire:model="roleId" id="usr-role"
                        class="form-select-base py-2 px-3 {{ $errors->has('roleId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:change="clearError('roleId')">
                        <option value="">Selecciona un rol…</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </x-ui.form-field>
            @endif

        </div>
    </form>
</div>
