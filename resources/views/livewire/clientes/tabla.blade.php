<div>
    <x-data-table :columns="[
        ['label' => '#', 'width' => 'w-[4%]'],
        ['label' => 'Cliente', 'width' => 'w-[28%]', 'align' => 'left'],
        ['label' => 'DPI', 'width' => 'w-[15%]'],
        ['label' => 'NIT', 'width' => 'w-[12%]'],
        ['label' => 'Tipo', 'width' => 'w-[14%]'],
        ['label' => 'Estado', 'width' => 'w-[10%]'],
        ['label' => 'Acciones', 'width' => 'w-[7%]'],
    ]" :skeleton-rows="5">

        {{-- ── Toolbar ─────────────────────────────────────────────── --}}
        <x-slot name="toolbar">
            {{-- Search --}}
            <div class="search-wrap w-full max-w-xs">
                <x-heroicon-o-magnifying-glass />
                <input wire:model.live.debounce.500ms="search" type="search" placeholder="Buscar cliente..."
                    autocomplete="off" />
            </div>

            {{-- Filters --}}
            <div class="flex items-center gap-2 flex-wrap">
                <select wire:model.live="tipoClienteId" class="form-select-base py-2 text-sm pr-8">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipoClientes as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>

                <select wire:model.live="estado" class="form-select-base py-2 text-sm pr-8">
                    <option value="">Todos los estados</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>

                <select wire:model.live="perPage" class="form-select-base py-2 text-sm w-20">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                </select>
            </div>
        </x-slot>

        {{-- ── Rows ────────────────────────────────────────────────── --}}
        @forelse ($clientes as $cliente)
            <tr class="table-row">
                {{-- # --}}
                <td class="table-cell text-center num text-slate-500 dark:text-slate-400 font-semibold">
                    {{ $loop->iteration }}
                </td>

                {{-- Cliente --}}
                <td class="table-cell text-left">
                    <div class="flex items-center gap-3">
                        <span class="avatar bg-primary-600 shrink-0">
                            {{ strtoupper(substr($cliente->nombres, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 dark:text-slate-200 truncate">
                                {{ $cliente->nombres }} {{ $cliente->apellidos }}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                                {{ $cliente->email ?: $cliente->direccion }}
                            </p>
                        </div>
                    </div>
                </td>

                {{-- DPI --}}
                <td class="table-cell text-center num">{{ $cliente->dpi }}</td>

                {{-- NIT --}}
                <td class="table-cell text-center num">{{ $cliente->nit }}</td>

                {{-- Tipo --}}
                <td class="table-cell text-center">
                    <span class="badge-primary">
                        {{ $cliente->tipoCliente->nombre }}
                    </span>
                </td>

                {{-- Estado --}}
                <td class="table-cell text-center">
                    <x-status-badge :status="$cliente->estado" :clickable="true" :wire-click="'cambiarEstado(' . $cliente->id . ')'" />
                </td>

                {{-- Acciones --}}
                <td class="table-cell text-center">
                    <div class="flex justify-center items-center gap-1">
                        <a href="{{ route('clientes.mostrar', $cliente->id) }}" wire:navigate class="btn-action-view"
                            title="Ver cliente" aria-label="Ver cliente">
                            <x-heroicon-o-eye class="w-4 h-4" />
                        </a>

                        <button wire:click="editar({{ $cliente->id }})" class="btn-action-edit" title="Editar cliente"
                            aria-label="Editar cliente">
                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                        </button>

                        @if (Auth::user()->role->nombre === 'Administrador')
                            <button wire:click="modalEliminar({{ $cliente->id }})" class="btn-action-delete"
                                title="Eliminar cliente" aria-label="Eliminar cliente">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-16">
                    <div class="empty-state">
                        <x-heroicon-o-users class="w-10 h-10" />
                        <p class="font-medium text-slate-500 dark:text-slate-400">No hay clientes registrados</p>
                        <p class="text-xs mt-1">Agrega el primer cliente con el botón de arriba.</p>
                    </div>
                </td>
            </tr>
        @endforelse

        {{-- ── Pagination ──────────────────────────────────────────── --}}
        <x-slot name="pagination">
            {{ $clientes->links('livewire::custom-pagination') }}
        </x-slot>

    </x-data-table>

    {{-- ── Modal: confirmar eliminación ──────────────────────────── --}}
    @if ($abrirModal)
        <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data
            x-on:keydown.escape.window="$wire.cerrarModal()">
            <div
                class="modal-panel w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                {{-- Header --}}
                <div
                    class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                            Eliminar cliente
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

                {{-- Body --}}
                <div class="px-5 py-4 space-y-4">
                    <p class="text-sm text-slate-700 dark:text-slate-300">
                        ¿Confirmas eliminar a
                        <span class="font-semibold text-rose-600 dark:text-rose-400">
                            {{ $nombres }} {{ $apellidos }}
                        </span>?
                        Ingresa tu contraseña para continuar.
                    </p>

                    <x-ui.form-field label="Contraseña" for="password-modal" :error="$errors->first('password')">
                        <input wire:model="password" id="password-modal" type="password"
                            class="form-input-base py-2 px-3 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                            placeholder="Tu contraseña" wire:keydown="clearError('password')"
                            autocomplete="current-password" />
                    </x-ui.form-field>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-2 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">
                        Cancelar
                    </button>
                    <button wire:click="eliminar" type="button" class="btn-danger" wire:loading.attr="disabled">
                        <x-heroicon-o-trash class="w-4 h-4" />
                        <span wire:loading.remove wire:target="eliminar">Eliminar</span>
                        <span wire:loading wire:target="eliminar">Eliminando…</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
