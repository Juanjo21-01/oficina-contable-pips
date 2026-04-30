<div>

    {{-- Toolbar --}}
    <div class="toolbar mb-4">
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            {{-- Add button --}}
            <flux:button wire:click="crear" variant="primary" icon="plus">
                Nuevo tipo
            </flux:button>

            {{-- Search --}}
            <div class="search-wrap w-full sm:w-64">
                <x-heroicon-o-magnifying-glass />
                <input wire:model.live.debounce.400ms="search" type="text"
                    placeholder="Buscar tipo…" />
            </div>
        </div>

        {{-- Per page --}}
        <div class="flex items-center gap-2">
            <span class="text-sm text-slate-500 dark:text-slate-400 shrink-0">Mostrar</span>
            <select wire:model.live="perPage" class="form-select-base py-1.5 px-2 w-20">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-container mb-4">
        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="table-header w-12">#</th>
                        <th class="table-header">Nombre</th>
                        <th class="table-header w-40">Trámites</th>
                        <th class="table-header w-32">Acciones</th>
                    </tr>
                </thead>
                {{-- Skeleton while Livewire loads --}}
                <tbody wire:loading.delay class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="table-cell"><div class="skeleton h-4 w-8 mx-auto"></div></td>
                        <td class="table-cell"><div class="skeleton h-4 w-48 rounded"></div></td>
                        <td class="table-cell"><div class="skeleton h-5 w-20 mx-auto rounded-full"></div></td>
                        <td class="table-cell"><div class="skeleton h-5 w-20 mx-auto rounded"></div></td>
                    </tr>
                    @endfor
                </tbody>

                {{-- Real rows --}}
                <tbody wire:loading.remove class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($tipoTramites as $tipoTramite)
                        <tr class="table-row">
                            <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="table-cell font-medium text-slate-800 dark:text-slate-200">
                                {{ $tipoTramite->nombre }}
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge-primary">
                                    {{ $tipoTramite->tramites->count() }}
                                    {{ $tipoTramite->tramites->count() === 1 ? 'trámite' : 'trámites' }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('tipo-tramites.mostrar', $tipoTramite->id) }}" wire:navigate
                                        class="btn-action-view" title="Ver tipo de trámite" aria-label="Ver">
                                        <x-heroicon-o-eye class="w-4 h-4" />
                                    </a>
                                    <button wire:click="editar({{ $tipoTramite->id }})"
                                        class="btn-action-edit" title="Editar tipo de trámite" aria-label="Editar">
                                        <x-heroicon-o-pencil class="w-4 h-4" />
                                    </button>
                                    @if (Auth::user()->role->nombre === 'Administrador')
                                        <button wire:click="modalEliminar({{ $tipoTramite->id }})"
                                            class="btn-action-delete" title="Eliminar tipo de trámite" aria-label="Eliminar">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <x-heroicon-o-document-text />
                                    <p class="font-medium">Sin tipos de trámites</p>
                                    <p class="mt-1">Crea el primero con el botón "Nuevo tipo".</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        {{ $tipoTramites->links('livewire::custom-pagination') }}
    </div>

    {{-- Delete confirm modal --}}
    @if ($abrirModal)
        <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-data x-on:keydown.escape.window="$wire.cerrarModal()">
            <div class="modal-panel w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-rose-600 dark:text-rose-400">
                            Eliminar Tipo No. {{ $tipoTramiteId }}
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            Esta acción no se puede deshacer.
                        </p>
                    </div>
                    <button wire:click="cerrarModal"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                <form wire:submit.prevent="eliminar" id="del-tipo-form" class="px-5 py-4 space-y-4">
                    <p class="text-sm text-slate-700 dark:text-slate-300">
                        ¿Eliminar el tipo de trámite
                        <span class="font-semibold text-rose-600 dark:text-rose-400">{{ $nombre }}</span>?
                    </p>

                    <x-ui.form-field label="Contraseña de confirmación" for="del-tipo-password"
                        :error="$errors->first('password')">
                        <input wire:model="password" id="del-tipo-password" type="password"
                            class="form-input-base py-2 px-3 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            wire:keydown="clearError('password')" placeholder="Tu contraseña" autofocus />
                    </x-ui.form-field>
                </form>

                <div class="flex justify-end gap-3 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">Cancelar</button>
                    <button type="submit" form="del-tipo-form" class="btn-danger" wire:loading.attr="disabled">
                        <x-heroicon-o-trash class="w-4 h-4" />
                        <span wire:loading.remove wire:target="eliminar">Eliminar</span>
                        <span wire:loading wire:target="eliminar">Eliminando…</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
