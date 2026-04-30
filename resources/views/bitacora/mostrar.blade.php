<x-app-layout>

    <x-ui.page-header
        :title="'Bitácora No. ' . request()->route('id')"
        description="Detalle del evento registrado.">
        <x-slot name="actions">
            <a href="{{ route('bitacora') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:bitacora.detalle :id="request()->route('id')" />

</x-app-layout>
