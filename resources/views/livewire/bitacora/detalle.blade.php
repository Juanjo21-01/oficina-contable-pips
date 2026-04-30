<div>
    <x-ui.section>
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 pb-4 mb-4 border-b border-slate-100 dark:border-slate-700">
            <div>
                <h2 class="text-xl font-display font-semibold text-slate-900 dark:text-slate-100">
                    {{ $bitacora->user->nombres }} {{ $bitacora->user->apellidos }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $bitacora->user->email }}</p>
            </div>
            <p class="num text-sm text-slate-500 dark:text-slate-400 shrink-0">
                {{ $bitacora->created_at->format('d/m/Y H:i:s') }}
            </p>
        </div>

        {{-- Details --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Tipo de evento</p>
                <div class="mt-2">
                    @if ($bitacora->tipo === 'creacion')
                        <span class="badge-active">Creación</span>
                    @elseif ($bitacora->tipo === 'eliminacion')
                        <span class="badge-inactive">Eliminación</span>
                    @elseif ($bitacora->tipo === 'reporte')
                        <span class="badge-pending">Reporte</span>
                    @endif
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Descripción</p>
                <p class="mt-2 text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                    {{ $bitacora->descripcion }}
                </p>
            </div>
        </div>
    </x-ui.section>
</div>
