<div>
    @if ($show)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-data x-on:keydown.escape.window="$wire.cerrarModal()">
            <div class="w-full max-w-sm bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">

                {{-- Header --}}
                <div class="flex items-start justify-between px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                            {{ $tipoTramiteId ? 'Editar tipo de trámite' : 'Nuevo tipo de trámite' }}
                        </h3>
                        @if ($tipoTramiteId)
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                Tipo No. {{ $tipoTramiteId }}
                            </p>
                        @endif
                    </div>
                    <button wire:click="cerrarModal"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Cerrar">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-5 py-4">
                    <livewire:tipo-tramites.formulario :tipoTramiteId="$tipoTramiteId" />
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 px-5 pb-5">
                    <button wire:click="cerrarModal" type="button" class="btn-secondary">
                        Cancelar
                    </button>
                    <flux:button type="submit" form="tipo-tramite-form"
                        :variant="$tipoTramiteId ? 'primary' : 'primary'"
                        wire:loading.attr="disabled">
                        <x-heroicon-o-check class="w-4 h-4" />
                        {{ $tipoTramiteId ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>

            </div>
        </div>
    @endif
</div>
