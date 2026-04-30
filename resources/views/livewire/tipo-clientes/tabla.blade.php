<div>

    {{-- Toolbar --}}
    <div class="toolbar mb-4">
        <div class="search-wrap w-full sm:w-72">
            <x-heroicon-o-magnifying-glass />
            <input wire:model.live.debounce.400ms="search" type="text"
                placeholder="Buscar tipo de cliente…" />
        </div>
    </div>

    {{-- Table --}}
    <div class="table-container lg:w-3/4 mx-auto">
        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="table-header w-16">#</th>
                        <th class="table-header">Nombre</th>
                        <th class="table-header w-36">Clientes</th>
                        <th class="table-header w-32">Acciones</th>
                    </tr>
                </thead>
                {{-- Skeleton while Livewire loads --}}
                <tbody wire:loading.delay class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @for ($i = 0; $i < 4; $i++)
                    <tr>
                        <td class="table-cell"><div class="skeleton h-4 w-8 mx-auto"></div></td>
                        <td class="table-cell"><div class="skeleton h-4 w-48 rounded"></div></td>
                        <td class="table-cell"><div class="skeleton h-5 w-20 mx-auto rounded-full"></div></td>
                        <td class="table-cell"><div class="skeleton h-5 w-16 mx-auto rounded"></div></td>
                    </tr>
                    @endfor
                </tbody>

                {{-- Real rows --}}
                <tbody wire:loading.remove class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($tipoClientes as $tipoCliente)
                        <tr class="table-row">
                            <td class="table-cell text-center font-semibold text-slate-500 dark:text-slate-400 num">
                                {{ $tipoCliente->id }}
                            </td>
                            <td class="table-cell font-medium text-slate-800 dark:text-slate-200">
                                {{ $tipoCliente->nombre }}
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge-primary">
                                    {{ $tipoCliente->clientes->count() }}
                                    {{ $tipoCliente->clientes->count() === 1 ? 'cliente' : 'clientes' }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('tipo-clientes.mostrar', $tipoCliente->id) }}" wire:navigate
                                        class="btn-action-view" title="Ver tipo de cliente" aria-label="Ver">
                                        <x-heroicon-o-eye class="w-4 h-4" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <x-heroicon-o-tag />
                                    <p class="font-medium">Sin tipos de clientes</p>
                                    @if ($search)
                                        <p class="text-slate-400 dark:text-slate-500 mt-1">
                                            Sin resultados para "{{ $search }}".
                                        </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
