<div>
    @if (Auth::user()->role->nombre === 'Administrador')

        {{-- Toolbar --}}
        <div class="toolbar mb-4">
            <flux:button wire:click="crear" variant="primary" icon="plus">
                Nuevo usuario
            </flux:button>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-full table-auto whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="table-header w-12">#</th>
                            <th class="table-header">Nombre</th>
                            <th class="table-header">Correo electrónico</th>
                            <th class="table-header w-36">Rol</th>
                            <th class="table-header w-28">Estado</th>
                            <th class="table-header w-32">Acciones</th>
                        </tr>
                    </thead>
                    {{-- Skeleton while Livewire loads --}}
                    <tbody wire:loading.delay class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                        @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td class="table-cell"><div class="skeleton h-4 w-8 mx-auto"></div></td>
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    <div class="skeleton w-8 h-8 rounded-full shrink-0"></div>
                                    <div class="skeleton h-4 w-36 rounded"></div>
                                </div>
                            </td>
                            <td class="table-cell"><div class="skeleton h-4 w-40 mx-auto"></div></td>
                            <td class="table-cell"><div class="skeleton h-5 w-20 mx-auto rounded-full"></div></td>
                            <td class="table-cell"><div class="skeleton h-5 w-16 mx-auto rounded-full"></div></td>
                            <td class="table-cell"><div class="skeleton h-5 w-20 mx-auto rounded"></div></td>
                        </tr>
                        @endfor
                    </tbody>

                    {{-- Real rows --}}
                    <tbody wire:loading.remove class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($usuarios as $usuario)
                            <tr class="table-row">
                                <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $colors = ['bg-primary-500','bg-brand-500','bg-amber-500','bg-rose-500','bg-purple-500'];
                                            $color  = $colors[$usuario->id % count($colors)];
                                        @endphp
                                        <div class="avatar {{ $color }}">
                                            {{ strtoupper(substr($usuario->nombres, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-800 dark:text-slate-200">
                                            {{ $usuario->nombres }} {{ $usuario->apellidos }}
                                        </span>
                                    </div>
                                </td>
                                <td class="table-cell text-slate-600 dark:text-slate-300">
                                    {{ $usuario->email }}
                                </td>
                                <td class="table-cell text-center">
                                    @if ($usuario->role->nombre === 'Administrador')
                                        <span class="badge-primary">Administrador</span>
                                    @else
                                        <span class="badge-pending">Empleado</span>
                                    @endif
                                </td>
                                <td class="table-cell text-center">
                                    <button
                                        wire:click="cambiarEstado({{ $usuario->id }})"
                                        @class([
                                            'badge-active cursor-pointer hover:opacity-80 transition-opacity' => $usuario->estado,
                                            'badge-inactive cursor-pointer hover:opacity-80 transition-opacity' => !$usuario->estado,
                                            'opacity-50 !cursor-not-allowed' => $usuario->role->nombre === 'Administrador',
                                        ])
                                        @disabled($usuario->role->nombre === 'Administrador')
                                        title="{{ $usuario->role->nombre === 'Administrador' ? 'No se puede cambiar el estado del administrador' : 'Cambiar estado' }}">
                                        {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('usuarios.mostrar', $usuario->id) }}" wire:navigate
                                            class="btn-action-view" title="Ver usuario" aria-label="Ver">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>
                                        <button wire:click="editar({{ $usuario->id }})"
                                            class="btn-action-edit" title="Editar usuario" aria-label="Editar">
                                            <x-heroicon-o-pencil class="w-4 h-4" />
                                        </button>
                                        @if ($usuario->role->nombre !== 'Administrador')
                                            <button wire:click="modalEliminar({{ $usuario->id }})"
                                                class="btn-action-delete" title="Eliminar usuario" aria-label="Eliminar">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <x-heroicon-o-users />
                                        <p class="font-medium">Sin usuarios</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Delete confirm modal --}}
        @if ($abrirModal)
            <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                x-data x-on:keydown.escape.window="$wire.cerrarModal()">
                <div class="modal-panel w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                    <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <h3 class="text-base font-semibold text-rose-600 dark:text-rose-400">
                                Eliminar Usuario No. {{ $usuarioId }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Esta acción no se puede deshacer.</p>
                        </div>
                        <button wire:click="cerrarModal"
                            class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            aria-label="Cerrar">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>

                    <form wire:submit.prevent="eliminar" id="del-usuario-form" class="px-5 py-4 space-y-4">
                        <p class="text-sm text-slate-700 dark:text-slate-300">
                            ¿Eliminar al usuario
                            <span class="font-semibold text-rose-600 dark:text-rose-400">
                                {{ $nombres }} {{ $apellidos }}
                            </span>?
                        </p>

                        <x-ui.form-field label="Contraseña de confirmación" for="del-usr-password"
                            :error="$errors->first('password')">
                            <input wire:model="password" id="del-usr-password" type="password"
                                class="form-input-base py-2 px-3 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('password')" placeholder="Tu contraseña" autofocus />
                        </x-ui.form-field>
                    </form>

                    <div class="flex justify-end gap-3 px-5 pb-5">
                        <button wire:click="cerrarModal" type="button" class="btn-secondary">Cancelar</button>
                        <button type="submit" form="del-usuario-form" class="btn-danger" wire:loading.attr="disabled">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            <span wire:loading.remove wire:target="eliminar">Eliminar</span>
                            <span wire:loading wire:target="eliminar">Eliminando…</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

    @else
        <div class="empty-state pt-24">
            <x-heroicon-o-lock-closed />
            <p class="font-medium text-slate-500 dark:text-slate-400">Acceso restringido</p>
            <p class="text-slate-400 dark:text-slate-500 mt-1">Solo administradores pueden ver esta sección.</p>
        </div>
    @endif
</div>
