<div>
    @if ($verUsuarios)
        <div class="mt-6">
            <x-ui.section>
                <x-slot name="title">
                    Usuarios — {{ $roles->find($roleId)?->nombre ?? 'Rol' }}
                </x-slot>
                <x-slot name="headerActions">
                    <button wire:click="cerrarUsuarios"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar" title="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </x-slot>

                @if ($usuarios->isEmpty())
                    <div class="empty-state py-8">
                        <x-heroicon-o-users />
                        <p>Sin usuarios en este rol</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($usuarios as $usuario)
                            @php
                                $colors = ['bg-primary-500','bg-brand-500','bg-amber-500','bg-rose-500','bg-purple-500'];
                                $color  = $colors[$usuario->id % count($colors)];
                            @endphp
                            <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 hover:border-slate-200 dark:hover:border-slate-600 transition-colors">
                                <div class="avatar {{ $color }} shrink-0">
                                    {{ strtoupper(substr($usuario->nombres, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 truncate">
                                        {{ $usuario->nombres }} {{ $usuario->apellidos }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                        {{ $usuario->email }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-2">
                                        @if ($usuario->estado)
                                            <span class="badge-active">Activo</span>
                                        @else
                                            <span class="badge-inactive">Inactivo</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('usuarios.mostrar', $usuario->id) }}" wire:navigate
                                    class="btn-action-view shrink-0" title="Ver usuario" aria-label="Ver">
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.section>
        </div>
    @endif
</div>
