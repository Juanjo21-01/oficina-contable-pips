<div>
    <form wire:submit.prevent="guardar" autocomplete="off" class="space-y-5 mb-6">

        {{-- Error global --}}
        @if ($errorMessage)
            <div class="flex items-center gap-2 px-4 py-3 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                {{ $errorMessage }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            {{-- ── Datos del cliente ───────────────────────────── --}}
            <x-ui.section title="Datos del cliente">
                <div class="space-y-4">
                    <x-ui.form-field label="Buscar cliente" for="buscarCliente">
                        <div class="search-wrap">
                            <x-heroicon-o-magnifying-glass />
                            <input wire:model.live.debounce.400ms="buscarCliente" id="buscarCliente"
                                type="text" placeholder="Nombre o apellido…"
                                class="form-input-base py-2 pl-9 pr-3" />
                        </div>
                    </x-ui.form-field>

                    <x-ui.form-field label="Cliente" for="cliente_id" required :error="$errors->first('clienteId')">
                        <select wire:model="clienteId" id="cliente_id"
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
                </div>
            </x-ui.section>

            {{-- ── Datos del tipo de trámite ───────────────────── --}}
            <x-ui.section title="Tipo de trámite">
                <div class="space-y-4">
                    <x-ui.form-field label="Buscar tipo" for="buscarTipoTramite">
                        <div class="search-wrap">
                            <x-heroicon-o-magnifying-glass />
                            <input wire:model.live.debounce.400ms="buscarTipoTramite" id="buscarTipoTramite"
                                type="text" placeholder="Nombre del tipo…"
                                class="form-input-base py-2 pl-9 pr-3" />
                        </div>
                    </x-ui.form-field>

                    <x-ui.form-field label="Tipo de trámite" for="tipo_tramite_id" required :error="$errors->first('tipoTramiteId')">
                        <select wire:model="tipoTramiteId" id="tipo_tramite_id"
                            class="form-select-base py-2 px-3 {{ $errors->has('tipoTramiteId') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:change="clearError('tipoTramiteId')">
                            <option value="">Seleccione un tipo…</option>
                            @foreach ($tiposTramites as $tipoTramite)
                                <option value="{{ $tipoTramite->id }}">{{ $tipoTramite->nombre }}</option>
                            @endforeach
                        </select>
                    </x-ui.form-field>
                </div>
            </x-ui.section>
        </div>

        {{-- ── Datos del trámite ────────────────────────────────── --}}
        <x-ui.section title="Datos del trámite">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <x-ui.form-field label="Fecha del trámite" for="fecha" required :error="$errors->first('fecha')">
                    <input wire:model="fecha" id="fecha" type="date"
                        class="form-input-base py-2 px-3 {{ $errors->has('fecha') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:keydown="clearError('fecha')" />
                </x-ui.form-field>

                <x-ui.form-field label="Precio del servicio" for="precio" required helper="En quetzales (Q)"
                    :error="$errors->first('precio')">
                    <input wire:model="precio" id="precio" type="number" step="0.01" min="0"
                        class="form-input-base py-2 px-3 num {{ $errors->has('precio') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:keydown="clearError('precio')" />
                </x-ui.form-field>

                <x-ui.form-field label="Gastos" for="gastos" helper="En quetzales (Q)" :error="$errors->first('gastos')">
                    <input wire:model="gastos" id="gastos" type="number" step="0.01" min="0"
                        class="form-input-base py-2 px-3 num {{ $errors->has('gastos') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:keydown="clearError('gastos')" />
                </x-ui.form-field>

                <x-ui.form-field label="Observaciones" for="observaciones" :error="$errors->first('observaciones')">
                    <textarea wire:model="observaciones" id="observaciones" rows="3"
                        class="form-input-base py-2 px-3 {{ $errors->has('observaciones') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                        wire:keydown="clearError('observaciones')"></textarea>
                </x-ui.form-field>

            </div>
        </x-ui.section>

        {{-- ── Botones ─────────────────────────────────────────── --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('tramites.index') }}" wire:navigate class="btn-secondary">
                Cancelar
            </a>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <x-heroicon-o-check class="w-4 h-4" />
                <span wire:loading.remove wire:target="guardar">Guardar trámite</span>
                <span wire:loading wire:target="guardar">Guardando…</span>
            </flux:button>
        </div>

    </form>
</div>
