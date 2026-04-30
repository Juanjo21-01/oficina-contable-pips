<div>

    <div class="space-y-5">

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 items-start">

            {{-- ─── Left: Perfil del cliente (2/5) ──────────────────────── --}}
            <div class="lg:col-span-2">
                <x-ui.section title="Información del cliente">

                    <x-slot name="headerActions">
                        <x-status-badge :status="$cliente->estado" :clickable="true" :wire-click="'cambiarEstado(' . $cliente->id . ')'" />
                        <button wire:click="editar({{ $cliente->id }})" class="btn-action-edit" title="Editar cliente"
                            aria-label="Editar cliente">
                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                        </button>
                    </x-slot>

                    {{-- Avatar --}}
                    <div class="flex items-center gap-4 mb-5 pb-5 border-b border-slate-100 dark:border-slate-700">
                        <span class="avatar avatar-lg bg-primary-600 text-xl">
                            {{ strtoupper(substr($cliente->nombres, 0, 1)) }}
                        </span>
                        <div>
                            <p
                                class="font-display font-semibold text-slate-900 dark:text-slate-100 text-lg leading-tight">
                                {{ $cliente->nombres }} {{ $cliente->apellidos }}
                            </p>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $cliente->tipoCliente->nombre }}
                            </p>
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 gap-y-4">

                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                DPI
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                                {{ $cliente->dpi }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                NIT
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                                {{ $cliente->nit }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                Teléfono</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                                {{ $cliente->telefono }}</dd>
                        </div>

                        @if ($cliente->email)
                            <div>
                                <dt
                                    class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                    Correo</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">
                                    {{ $cliente->email }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                Dirección</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                {{ $cliente->direccion }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                Registrado por</dt>
                            <dd class="mt-1 text-sm text-slate-700 dark:text-slate-300">
                                {{ $cliente->user->name ?? '—' }}
                            </dd>
                        </div>

                    </dl>

                </x-ui.section>
            </div>

            {{-- ─── Right: Tabs (3/5) ──────────────────────────────────── --}}
            <div class="lg:col-span-3" x-data="{ tab: 'tramites' }">

                {{-- Tab nav --}}
                <div class="flex gap-1 mb-4 bg-slate-100 dark:bg-slate-800 rounded-lg p-1">
                    <button type="button" @click="tab = 'tramites'"
                        :class="tab === 'tramites'
                            ?
                            'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                            'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
                        <x-heroicon-o-document-text class="w-4 h-4" />
                        Trámites
                    </button>
                    <button type="button" @click="tab = 'agencia'"
                        :class="tab === 'agencia'
                            ?
                            'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                            'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
                        <x-heroicon-o-building-office class="w-4 h-4" />
                        Agencia virtual
                    </button>
                    <button type="button" @click="tab = 'historial'"
                        :class="tab === 'historial'
                            ?
                            'bg-white dark:bg-slate-700 shadow-sm text-primary-600 dark:text-primary-400' :
                            'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-sm font-medium rounded-md transition-colors duration-150">
                        <x-heroicon-o-clock class="w-4 h-4" />
                        Historial
                    </button>
                </div>

                {{-- ── Tab: Trámites ──────────────────────────────────── --}}
                <div x-show="tab === 'tramites'" x-transition>

                    @php
                        $clienteChartOptions = [
                            'plugins' => [
                                'legend' => ['position' => 'top'],
                            ],
                            'scales' => [
                                'y' => ['beginAtZero' => true, 'ticks' => ['stepSize' => 1]],
                            ],
                        ];
                    @endphp

                    {{-- Chart --}}
                    <x-ui.section title="Actividad — últimos 6 meses" class="mb-4">
                        <div class="h-52">
                            <canvas id="myChart" class="w-full h-full" data-chart='@json($chartData)'
                                data-chart-options='@json($clienteChartOptions)'></canvas>
                        </div>
                    </x-ui.section>

                    {{-- Table --}}
                    <x-ui.section title="Últimos trámites">

                        <x-slot name="headerActions">
                            <a href="{{ route('tramites.index') }}" wire:navigate
                                class="text-xs text-primary-600 dark:text-primary-400 hover:underline inline-flex items-center gap-1">
                                Ver todos
                                <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                            </a>
                        </x-slot>

                        <div class="table-container">
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-full table-auto whitespace-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="table-header w-[5%]">#</th>
                                            <th class="table-header w-[38%] text-left">Tipo de trámite</th>
                                            <th class="table-header w-[18%]">Precio</th>
                                            <th class="table-header w-[18%]">Fecha</th>
                                            <th class="table-header w-[8%]">PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                                        @forelse ($cliente->tramites->sortByDesc('created_at')->take(5) as $tramite)
                                            <tr class="table-row">
                                                <td class="table-cell text-center num text-slate-500 font-semibold">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="table-cell text-left">
                                                    {{ $tramite->tipoTramite->nombre }}
                                                </td>
                                                <td class="table-cell text-center num font-semibold">
                                                    Q{{ number_format($tramite->precio, 2) }}
                                                </td>
                                                <td class="table-cell text-center num">
                                                    {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                                </td>
                                                <td class="table-cell text-center">
                                                    <a href="{{ route('tramites.pdf', $tramite->id) }}"
                                                        class="btn-action-edit inline-flex" title="Descargar PDF"
                                                        aria-label="Descargar PDF">
                                                        <x-heroicon-o-document-arrow-down class="w-4 h-4" />
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="py-10">
                                                    <div class="empty-state">
                                                        <x-heroicon-o-document-text class="w-8 h-8" />
                                                        <p>Sin trámites registrados</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </x-ui.section>

                </div>

                {{-- ── Tab: Agencia virtual ───────────────────────────── --}}
                <div x-show="tab === 'agencia'" x-transition>
                    <x-ui.section title="Agencia virtual">

                        <x-slot name="headerActions">
                            @if ($cliente->agenciaVirtual)
                                <a href="https://farm3.sat.gob.gt/menu/login.jsf" target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-action-view inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg">
                                    <x-heroicon-o-arrow-top-right-on-square class="w-3.5 h-3.5" />
                                    Visitar agencia
                                </a>
                                <button wire:click="editarAgencia" class="btn-action-edit" title="Editar agencia"
                                    aria-label="Editar agencia">
                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                </button>
                            @else
                                <flux:button type="button" wire:click="abrirAgencia" variant="primary" size="sm">
                                    Crear agencia
                                </flux:button>
                            @endif
                        </x-slot>

                        @if ($cliente->agenciaVirtual)
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-8">

                                <div>
                                    <dt
                                        class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                        Correo de agencia</dt>
                                    <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">
                                        {{ $cliente->agenciaVirtual->correo }}
                                    </dd>
                                </div>

                                <div>
                                    <dt
                                        class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                        Usuario (NIT)</dt>
                                    <dd class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200 num">
                                        {{ $cliente->nit }}</dd>
                                </div>

                                <div class="sm:col-span-2">
                                    <dt
                                        class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                        Contraseña</dt>
                                    <dd x-data="{ show: false }" class="mt-1 flex items-center gap-2">
                                        <span
                                            class="text-sm font-semibold text-slate-800 dark:text-slate-200 font-mono"
                                            x-text="show ? '{{ $cliente->agenciaVirtual->password }}' : '••••••••'"></span>
                                        <button type="button" @click="show = !show"
                                            class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                                            :aria-label="show ? 'Ocultar' : 'Mostrar'">
                                            <template x-if="!show"><x-heroicon-o-eye class="w-4 h-4" /></template>
                                            <template x-if="show"><x-heroicon-o-eye-slash
                                                    class="w-4 h-4" /></template>
                                        </button>
                                    </dd>
                                </div>

                                @if ($cliente->agenciaVirtual->observaciones)
                                    <div class="sm:col-span-2">
                                        <dt
                                            class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                            Observaciones</dt>
                                        <dd class="mt-1 text-sm text-slate-700 dark:text-slate-300">
                                            {{ $cliente->agenciaVirtual->observaciones }}
                                        </dd>
                                    </div>
                                @endif

                            </dl>
                        @else
                            <div class="empty-state py-10">
                                <x-heroicon-o-building-office class="w-10 h-10" />
                                <p class="font-medium">Sin agencia virtual</p>
                                <p class="text-xs mt-1">Este cliente no tiene credenciales de agencia registradas.</p>
                            </div>
                        @endif

                    </x-ui.section>
                </div>

                {{-- ── Tab: Historial ─────────────────────────────────── --}}
                <div x-show="tab === 'historial'" x-transition>
                    <x-ui.section title="Historial de trámites">
                        @forelse ($cliente->tramites->sortByDesc('fecha') as $tramite)
                            <div class="flex gap-3 {{ !$loop->last ? 'mb-1' : '' }}">
                                <div class="flex flex-col items-center pt-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-primary-500 shrink-0"></span>
                                    @if (!$loop->last)
                                        <span class="w-px flex-1 bg-slate-200 dark:bg-slate-700 mt-1 mb-0"></span>
                                    @endif
                                </div>
                                <div class="pb-4 min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        {{ $tramite->tipoTramite->nombre }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 num">
                                        {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                        &nbsp;·&nbsp;
                                        Q{{ number_format($tramite->precio, 2) }}
                                    </p>
                                    @if ($tramite->observaciones)
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 truncate">
                                            {{ $tramite->observaciones }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state py-10">
                                <x-heroicon-o-clock class="w-8 h-8" />
                                <p>Sin actividad registrada</p>
                            </div>
                        @endforelse
                    </x-ui.section>
                </div>

            </div>
        </div>

        {{-- ── Modal: agencia virtual (crear / editar) ──────────────── --}}
        @if ($abrirModalAgencia)
            <div class="modal-backdrop fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                x-data x-on:keydown.escape.window="$wire.cerrarModalAgencia()">
                <div
                    class="modal-panel w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                    {{-- Header --}}
                    <div
                        class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                                {{ $cliente->agenciaVirtual ? 'Editar' : 'Crear' }} agencia virtual
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $cliente->nombres }} {{ $cliente->apellidos }}
                            </p>
                        </div>
                        <button wire:click="cerrarModalAgencia"
                            class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            aria-label="Cerrar">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>

                    {{-- Form --}}
                    <form wire:submit.prevent="agregarAgenciaVirtual" class="px-5 py-4 space-y-4">

                        @if ($errorMessage)
                            <div
                                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                                <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                                {{ $errorMessage }}
                            </div>
                        @endif

                        <x-ui.form-field label="Correo de la agencia" for="correo-agencia" required :error="$errors->first('correo')">
                            <input wire:model="correo" id="correo-agencia" type="email"
                                class="form-input-base py-2 px-3 {{ $errors->has('correo') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('correo')" autofocus />
                        </x-ui.form-field>

                        <x-ui.form-field label="Contraseña" for="contrasenia-agencia" required :error="$errors->first('contrasenia')">
                            <div x-data="{ show: false }" class="relative">
                                <input wire:model="contrasenia" id="contrasenia-agencia"
                                    :type="show ? 'text' : 'password'"
                                    class="form-input-base py-2 pl-3 pr-10 {{ $errors->has('contrasenia') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                    wire:keydown="clearError('contrasenia')" />
                                <button type="button" @click="show = !show"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                                    :aria-label="show ? 'Ocultar' : 'Mostrar'">
                                    <template x-if="!show"><x-heroicon-o-eye class="w-4 h-4" /></template>
                                    <template x-if="show"><x-heroicon-o-eye-slash class="w-4 h-4" /></template>
                                </button>
                            </div>
                        </x-ui.form-field>

                        <x-ui.form-field label="Observaciones" for="obs-agencia" helper="Opcional" :error="$errors->first('observaciones')">
                            <textarea wire:model="observaciones" id="obs-agencia" rows="3"
                                class="form-input-base py-2 px-3 {{ $errors->has('observaciones') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                                wire:keydown="clearError('observaciones')"></textarea>
                        </x-ui.form-field>

                        <div class="flex justify-end gap-3 pt-1">
                            <flux:button type="button" wire:click="cerrarModalAgencia" variant="ghost">
                                Cancelar
                            </flux:button>
                            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="agregarAgenciaVirtual">
                                    {{ $cliente->agenciaVirtual ? 'Actualizar' : 'Guardar' }}
                                </span>
                                <span wire:loading wire:target="agregarAgenciaVirtual">Guardando…</span>
                            </flux:button>
                        </div>

                    </form>

                </div>
            </div>
        @endif

    </div>

</div>
