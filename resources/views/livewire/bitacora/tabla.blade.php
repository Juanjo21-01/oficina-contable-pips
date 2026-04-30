<div>
    {{-- Toolbar --}}
    <div class="toolbar mb-4">
        <div class="search-wrap">
            <x-heroicon-o-magnifying-glass class="w-4 h-4 text-slate-400 shrink-0" />
            <input wire:model.live.debounce.400ms="search" type="text" placeholder="Buscar responsable…"
                class="w-full bg-transparent text-sm text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none" />
        </div>
        <select wire:model.live="tipo"
            class="form-select-base py-1.5 px-3 text-sm w-40">
            <option value="">Todos los tipos</option>
            <option value="creacion">Creación</option>
            <option value="eliminacion">Eliminación</option>
            <option value="reporte">Reporte</option>
        </select>
        <select wire:model.live="perPage"
            class="form-select-base py-1.5 px-3 text-sm w-24">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
        </select>
    </div>

    {{-- Timeline feed --}}
    <div class="table-container">
        @forelse ($bitacoras as $bitacora)
            @php
                $isCreacion    = $bitacora->tipo === 'creacion';
                $isEliminacion = $bitacora->tipo === 'eliminacion';
                $isReporte     = $bitacora->tipo === 'reporte';
                $dotBg   = $isCreacion ? 'bg-brand-50 dark:bg-brand-900/20 border-brand-200 dark:border-brand-800'
                         : ($isEliminacion ? 'bg-rose-50 dark:bg-rose-900/20 border-rose-200 dark:border-rose-800'
                         : 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800');
                $iconColor = $isCreacion ? 'text-brand-600 dark:text-brand-400'
                           : ($isEliminacion ? 'text-rose-600 dark:text-rose-400'
                           : 'text-amber-600 dark:text-amber-400');
            @endphp

            <div class="flex gap-4 px-5 py-4 border-b border-slate-100 dark:border-slate-700 last:border-b-0 group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors duration-150">

                {{-- Icon bubble + connector line --}}
                <div class="flex flex-col items-center shrink-0 pt-0.5">
                    <div class="w-8 h-8 rounded-full border flex items-center justify-center {{ $dotBg }}">
                        @if ($isCreacion)
                            <x-heroicon-o-plus-circle class="w-4 h-4 {{ $iconColor }}" />
                        @elseif ($isEliminacion)
                            <x-heroicon-o-trash class="w-4 h-4 {{ $iconColor }}" />
                        @else
                            <x-heroicon-o-document-chart-bar class="w-4 h-4 {{ $iconColor }}" />
                        @endif
                    </div>
                    @if (!$loop->last)
                        <div class="w-px flex-1 mt-2 bg-slate-200 dark:bg-slate-700"></div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0 pb-4">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold text-sm text-slate-800 dark:text-slate-200">
                                    {{ $bitacora->user->nombres }} {{ $bitacora->user->apellidos }}
                                </span>
                                @if ($isCreacion)
                                    <span class="badge-active">Creación</span>
                                @elseif ($isEliminacion)
                                    <span class="badge-inactive">Eliminación</span>
                                @else
                                    <span class="badge-pending">Reporte</span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                {{ $bitacora->descripcion }}
                            </p>
                            <p class="num text-xs text-slate-400 dark:text-slate-500 mt-1">
                                {{ $bitacora->created_at->format('d/m/Y') }}
                                <span class="mx-1">·</span>
                                {{ $bitacora->created_at->format('H:i') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                            <a href="{{ route('bitacora.mostrar', $bitacora->id) }}" wire:navigate
                                class="btn-action-view" title="Ver detalle" aria-label="Ver">
                                <x-heroicon-o-eye class="w-4 h-4" />
                            </a>
                            @if ($bitacora->tipo !== 'eliminacion')
                                <button wire:click="modalEliminar({{ $bitacora->id }})"
                                    class="btn-action-delete" title="Eliminar" aria-label="Eliminar">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="empty-state py-12">
                <x-heroicon-o-clipboard-document-list />
                <p class="font-medium">Sin registros en la bitácora</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($bitacoras->hasPages())
            <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700">
                {{ $bitacoras->links('livewire::custom-pagination') }}
            </div>
        @endif
    </div>

    {{-- Delete confirm modal --}}
    @if ($abrirModal)
        <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-data x-on:keydown.escape.window="$wire.cerrarModal()">
            <div class="modal-panel w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-rose-600 dark:text-rose-400">
                            Eliminar Bitácora No. {{ $bitacoraId }}
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Esta acción no se puede deshacer.</p>
                    </div>
                    <button wire:click="cerrarModal"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                <form wire:submit.prevent="eliminar" id="del-bitacora-form" class="px-5 py-4 space-y-4">
                    <p class="text-sm text-slate-700 dark:text-slate-300">
                        ¿Eliminar el registro de tipo
                        <span class="font-semibold text-rose-600 dark:text-rose-400">{{ $tipoBitacora }}</span>
                        del responsable
                        <span class="font-semibold text-rose-600 dark:text-rose-400">{{ $usuarioNombre }}</span>?
                    </p>

                    <x-ui.form-field label="Contraseña de confirmación" for="del-bit-password"
                        :error="$errors->first('password')">
                        <input wire:model="password" id="del-bit-password" type="password"
                            class="form-input-base py-2 px-3 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('password')" placeholder="Tu contraseña" autofocus />
                    </x-ui.form-field>
                </form>

                <div class="flex justify-end gap-3 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">Cancelar</button>
                    <button type="submit" form="del-bitacora-form" class="btn-danger" wire:loading.attr="disabled">
                        <x-heroicon-o-trash class="w-4 h-4" />
                        <span wire:loading.remove wire:target="eliminar">Eliminar</span>
                        <span wire:loading wire:target="eliminar">Eliminando…</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
