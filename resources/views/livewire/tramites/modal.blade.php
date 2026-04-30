<div>
    @if ($show)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-data x-on:keydown.escape.window="$wire.cerrarModal()">
            <div class="w-full max-w-xl bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                {{-- Header --}}
                <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                            Editar trámite
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            Trámite No. {{ $tramiteId }}
                        </p>
                    </div>
                    <button wire:click="cerrarModal"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                {{-- Body --}}
                <form id="modal-tramite-form" wire:submit.prevent="actualizar" class="px-5 py-4">

                    @if ($errorMessage)
                        <div class="flex items-center gap-2 px-4 py-3 mb-4 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                            <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                            {{ $errorMessage }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <x-ui.form-field label="Cliente" for="modal-clienteId" required :error="$errors->first('clienteId')">
                            <select wire:model="clienteId" id="modal-clienteId"
                                class="form-select-base py-2 px-3 {{ $errors->has('clienteId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:change="clearError('clienteId')">
                                <option value="">Seleccione un cliente…</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">
                                        {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </x-ui.form-field>

                        <x-ui.form-field label="Tipo de trámite" for="modal-tipoTramiteId" required :error="$errors->first('tipoTramiteId')">
                            <select wire:model="tipoTramiteId" id="modal-tipoTramiteId"
                                class="form-select-base py-2 px-3 {{ $errors->has('tipoTramiteId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:change="clearError('tipoTramiteId')">
                                <option value="">Seleccione un tipo…</option>
                                @foreach ($tiposTramites as $tipoTramite)
                                    <option value="{{ $tipoTramite->id }}">{{ $tipoTramite->nombre }}</option>
                                @endforeach
                            </select>
                        </x-ui.form-field>

                        <x-ui.form-field label="Fecha" for="modal-fecha" required :error="$errors->first('fecha')">
                            <input wire:model="fecha" id="modal-fecha" type="date"
                                class="form-input-base py-2 px-3 {{ $errors->has('fecha') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('fecha')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Precio" for="modal-precio" required helper="En quetzales (Q)"
                            :error="$errors->first('precio')">
                            <input wire:model="precio" id="modal-precio" type="number" step="0.01" min="0"
                                class="form-input-base py-2 px-3 num {{ $errors->has('precio') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('precio')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Gastos" for="modal-gastos" helper="En quetzales (Q)"
                            :error="$errors->first('gastos')">
                            <input wire:model="gastos" id="modal-gastos" type="number" step="0.01" min="0"
                                class="form-input-base py-2 px-3 num {{ $errors->has('gastos') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('gastos')" />
                        </x-ui.form-field>

                        <x-ui.form-field label="Observaciones" for="modal-observaciones" :error="$errors->first('observaciones')">
                            <textarea wire:model="observaciones" id="modal-observaciones" rows="3"
                                class="form-input-base py-2 px-3 {{ $errors->has('observaciones') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('observaciones')"></textarea>
                        </x-ui.form-field>

                    </div>
                </form>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">
                        Cancelar
                    </button>
                    <flux:button type="submit" form="modal-tramite-form" variant="primary" wire:loading.attr="disabled">
                        <x-heroicon-o-check class="w-4 h-4" />
                        <span wire:loading.remove wire:target="actualizar">Actualizar</span>
                        <span wire:loading wire:target="actualizar">Guardando…</span>
                    </flux:button>
                </div>

            </div>
        </div>
    @endif
</div>
