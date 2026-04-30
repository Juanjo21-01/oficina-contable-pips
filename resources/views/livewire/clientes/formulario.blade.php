@php
    $tabDefault = 'personal';
    if (
        $errors->hasAny(['correo', 'contrasenia', 'observaciones']) &&
        !$errors->hasAny(['nombres', 'apellidos', 'dpi', 'nit', 'direccion', 'telefono', 'email', 'tipoClienteId'])
    ) {
        $tabDefault = 'agencia';
    }
@endphp

<div x-data="{ tab: '{{ $tabDefault }}' }">

    {{-- ── Error global ──────────────────────────────────────────── --}}
    @if ($errorMessage)
        <div
            class="flex items-center gap-2 px-4 py-3 mb-5 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
            <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
            {{ $errorMessage }}
        </div>
    @endif

    {{-- ── Tab nav ────────────────────────────────────────────────── --}}
    <div class="flex gap-1 mb-6 bg-slate-100 dark:bg-slate-800 rounded-lg p-1">
        <button type="button" @click="tab = 'personal'"
            :class="tab === 'personal'
                ?
                'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
            <x-heroicon-o-user class="w-4 h-4" />
            <span>Datos personales</span>
            @if ($errors->hasAny(['nombres', 'apellidos', 'dpi', 'nit', 'direccion', 'telefono', 'email', 'tipoClienteId']))
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            @endif
        </button>
        <button type="button" @click="tab = 'agencia'"
            :class="tab === 'agencia'
                ?
                'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
            <x-heroicon-o-building-office class="w-4 h-4" />
            <span>Agencia virtual</span>
            @if ($errors->hasAny(['correo', 'contrasenia']))
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            @endif
        </button>
        <button type="button" @click="tab = 'preferencias'"
            :class="tab === 'preferencias'
                ?
                'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
            <x-heroicon-o-cog-6-tooth class="w-4 h-4" />
            <span>Preferencias</span>
        </button>
    </div>

    <form wire:submit.prevent="guardar" autocomplete="off" class="space-y-5 mb-6">

        {{-- ── Tab 1: Datos personales ─────────────────────────── --}}
        <div x-show="tab === 'personal'" x-transition>
            <x-ui.section title="Datos personales">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <x-ui.form-field label="Nombres" for="nombres" required :error="$errors->first('nombres')">
                        <input wire:model="nombres" id="nombres" type="text"
                            class="form-input-base py-2 px-3 {{ $errors->has('nombres') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('nombres')" autofocus />
                    </x-ui.form-field>

                    <x-ui.form-field label="Apellidos" for="apellidos" required :error="$errors->first('apellidos')">
                        <input wire:model="apellidos" id="apellidos" type="text"
                            class="form-input-base py-2 px-3 {{ $errors->has('apellidos') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('apellidos')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="DPI" for="dpi" required helper="13 dígitos sin espacios"
                        :error="$errors->first('dpi')">
                        <input wire:model="dpi" id="dpi" type="text" maxlength="13"
                            class="form-input-base py-2 px-3 num {{ $errors->has('dpi') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('dpi')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="NIT" for="nit" required helper="Sin guión ni verificador"
                        :error="$errors->first('nit')">
                        <input wire:model="nit" id="nit" type="text" maxlength="13"
                            class="form-input-base py-2 px-3 num {{ $errors->has('nit') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('nit')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="Teléfono" for="telefono" required :error="$errors->first('telefono')">
                        <input wire:model="telefono" id="telefono" type="text" maxlength="8"
                            class="form-input-base py-2 px-3 num {{ $errors->has('telefono') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('telefono')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="Correo electrónico" for="email" helper="Opcional" :error="$errors->first('email')">
                        <input wire:model="email" id="email" type="email"
                            class="form-input-base py-2 px-3 {{ $errors->has('email') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('email')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="Tipo de cliente" for="tipo_cliente_id" required :error="$errors->first('tipoClienteId')">
                        <select wire:model="tipoClienteId" id="tipo_cliente_id"
                            class="form-select-base py-2 px-3 {{ $errors->has('tipoClienteId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:change="clearError('tipoClienteId')">
                            <option value="">Selecciona un tipo…</option>
                            @foreach ($tipoClientes as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </x-ui.form-field>

                    <x-ui.form-field label="Dirección" for="direccion" required :error="$errors->first('direccion')">
                        <input wire:model="direccion" id="direccion" type="text"
                            class="form-input-base py-2 px-3 {{ $errors->has('direccion') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('direccion')" />
                    </x-ui.form-field>

                </div>
            </x-ui.section>

            {{-- Next → --}}
            <div class="flex justify-end mt-4">
                <button type="button" @click="tab = 'agencia'" class="btn-secondary">
                    Siguiente: Agencia virtual
                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                </button>
            </div>
        </div>

        {{-- ── Tab 2: Agencia virtual ──────────────────────────── --}}
        <div x-show="tab === 'agencia'" x-transition>
            <x-ui.section title="Agencia virtual"
                description="Opcional — déjalo vacío si el cliente aún no tiene acceso.">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <x-ui.form-field label="Correo de la agencia" for="correo"
                        helper="Requerido si se añade agencia" :error="$errors->first('correo')">
                        <input wire:model="correo" id="correo" type="email"
                            class="form-input-base py-2 px-3 {{ $errors->has('correo') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('correo')" />
                    </x-ui.form-field>

                    <x-ui.form-field label="Contraseña" for="contrasenia" helper="Mínimo 8 caracteres"
                        :error="$errors->first('contrasenia')">
                        <div x-data="{ show: false }" class="relative">
                            <input wire:model="contrasenia" id="contrasenia" :type="show ? 'text' : 'password'"
                                class="form-input-base py-2 pl-3 pr-10 {{ $errors->has('contrasenia') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('contrasenia')" />
                            <button type="button" @click="show = !show"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                                :aria-label="show ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                                <template x-if="!show"><x-heroicon-o-eye class="w-4 h-4" /></template>
                                <template x-if="show"><x-heroicon-o-eye-slash class="w-4 h-4" /></template>
                            </button>
                        </div>
                    </x-ui.form-field>

                    <div class="sm:col-span-2">
                        <x-ui.form-field label="Observaciones" for="observaciones" helper="Opcional"
                            :error="$errors->first('observaciones')">
                            <textarea wire:model="observaciones" id="observaciones" rows="3"
                                class="form-input-base py-2 px-3 {{ $errors->has('observaciones') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('observaciones')"></textarea>
                        </x-ui.form-field>
                    </div>

                </div>
            </x-ui.section>

            <div class="flex justify-between mt-4">
                <button type="button" @click="tab = 'personal'" class="btn-secondary">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Anterior
                </button>
                <button type="button" @click="tab = 'preferencias'" class="btn-secondary">
                    Siguiente: Preferencias
                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                </button>
            </div>
        </div>

        {{-- ── Tab 3: Preferencias ─────────────────────────────── --}}
        <div x-show="tab === 'preferencias'" x-transition>
            <x-ui.section title="Preferencias" description="Configura el estado inicial del cliente.">
                <div class="space-y-4">

                    <div
                        class="flex items-center justify-between py-3 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Cliente activo</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Los clientes inactivos no aparecen en filtros por defecto.
                            </p>
                        </div>
                        <button type="button" wire:click="$set('estado', !{{ $estado ? 'true' : 'false' }})"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2 {{ $estado ? 'bg-primary-600' : 'bg-slate-300 dark:bg-slate-600' }}"
                            role="switch" :aria-checked="{{ $estado ? 'true' : 'false' }}"
                            aria-label="Estado del cliente">
                            <span
                                class="pointer-events-none inline-block h-5 w-5 translate-x-0 rounded-full bg-white shadow ring-0 transition duration-200 {{ $estado ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Estado actual:
                        <span
                            class="font-semibold {{ $estado ? 'text-brand-600 dark:text-brand-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>

                </div>
            </x-ui.section>

            <div class="flex justify-between mt-4">
                <button type="button" @click="tab = 'agencia'" class="btn-secondary">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Anterior
                </button>
                {{-- Submit final --}}
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <x-heroicon-o-check class="w-4 h-4" />
                    <span wire:loading.remove wire:target="guardar">Guardar cliente</span>
                    <span wire:loading wire:target="guardar">Guardando…</span>
                </flux:button>
            </div>
        </div>

        {{-- ── Submit visible en tabs 1 y 2 también ───────────── --}}
        <div x-show="tab !== 'preferencias'"
            class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800">
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <x-heroicon-o-check class="w-4 h-4" />
                <span wire:loading.remove wire:target="guardar">Guardar cliente</span>
                <span wire:loading wire:target="guardar">Guardando…</span>
            </flux:button>
        </div>

    </form>

</div>
