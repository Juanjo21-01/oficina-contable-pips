<div>
    @if ($show)
        <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data
            x-on:keydown.escape.window="$wire.cerrarModal()">
            <div
                class="modal-panel w-full max-w-2xl bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                {{-- Header --}}
                <div
                    class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                            Editar cliente
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            Cliente No. {{ $clienteId }}
                        </p>
                    </div>
                    <button wire:click="cerrarModal"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                {{-- Body --}}
                <form id="modal-form" wire:submit.prevent="actualizar" class="px-5 py-4">

                    @if ($errorMessage)
                        <div
                            class="flex items-center gap-2 px-4 py-3 mb-4 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                            <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                            {{ $errorMessage }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <x-ui.form-field label="Nombres" for="modal-nombres" required :error="$errors->first('nombres')">
                            <input wire:model="nombres" id="modal-nombres" type="text"
                                class="form-input-base py-2 px-3 {{ $errors->has('nombres') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('nombres')" autofocus />
                        </x-ui.form-field>

                        <x-ui.form-field label="Apellidos" for="modal-apellidos" required :error="$errors->first('apellidos')">
                            <input wire:model="apellidos" id="modal-apellidos" type="text"
                                class="form-input-base py-2 px-3 {{ $errors->has('apellidos') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('apellidos')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="DPI" for="modal-dpi" required helper="13 dígitos" :error="$errors->first('dpi')">
                            <input wire:model="dpi" id="modal-dpi" type="text" maxlength="13"
                                class="form-input-base py-2 px-3 num {{ $errors->has('dpi') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('dpi')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="NIT" for="modal-nit" required :error="$errors->first('nit')">
                            <input wire:model="nit" id="modal-nit" type="text" maxlength="13"
                                class="form-input-base py-2 px-3 num {{ $errors->has('nit') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('nit')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Teléfono" for="modal-telefono" required :error="$errors->first('telefono')">
                            <input wire:model="telefono" id="modal-telefono" type="text" maxlength="8"
                                class="form-input-base py-2 px-3 num {{ $errors->has('telefono') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('telefono')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Correo electrónico" for="modal-email" helper="Opcional"
                            :error="$errors->first('email')">
                            <input wire:model="email" id="modal-email" type="email"
                                class="form-input-base py-2 px-3 {{ $errors->has('email') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('email')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Tipo de cliente" for="modal-tipo" required :error="$errors->first('tipoClienteId')">
                            <select wire:model="tipoClienteId" id="modal-tipo"
                                class="form-select-base py-2 px-3 {{ $errors->has('tipoClienteId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:change="clearError('tipoClienteId')">
                                <option value="">Selecciona un tipo…</option>
                                @foreach ($tipoClientes as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </x-ui.form-field>

                        <x-ui.form-field label="Dirección" for="modal-direccion" required :error="$errors->first('direccion')">
                            <input wire:model="direccion" id="modal-direccion" type="text"
                                class="form-input-base py-2 px-3 {{ $errors->has('direccion') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('direccion')" />
                        </x-ui.form-field>

                    </div>

                </form>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">
                        Cancelar
                    </button>
                    <flux:button type="submit" form="modal-form" variant="primary" wire:loading.attr="disabled">
                        <x-heroicon-o-check class="w-4 h-4" />
                        <span wire:loading.remove wire:target="actualizar">Actualizar</span>
                        <span wire:loading wire:target="actualizar">Guardando…</span>
                    </flux:button>
                </div>

            </div>
        </div>
    @endif
</div>
