<div>
    @if (Auth::user()->role->nombre === 'Administrador')

        {{-- Table --}}
        <div class="table-container">
            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-full table-auto whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="table-header w-12">#</th>
                            <th class="table-header">Nombre</th>
                            <th class="table-header w-28">Usuarios</th>
                            <th class="table-header w-32">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach ($roles as $role)
                            <tr class="table-row">
                                <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table-cell">
                                    @if ($role->nombre === 'Administrador')
                                        <span class="badge-primary">Administrador</span>
                                    @else
                                        <span class="badge-pending">Empleado</span>
                                    @endif
                                </td>
                                <td class="table-cell text-center">
                                    <span class="badge-info">{{ $role->users->count() }}</span>
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-center">
                                        <button wire:click="verUsuarios({{ $role->id }})"
                                            class="btn-action-view" title="Ver usuarios del rol" aria-label="Ver">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        <div class="empty-state pt-24">
            <x-heroicon-o-lock-closed />
            <p class="font-medium text-slate-500 dark:text-slate-400">Acceso restringido</p>
            <p class="text-slate-400 dark:text-slate-500 mt-1">Solo administradores pueden ver esta sección.</p>
        </div>
    @endif
</div>
