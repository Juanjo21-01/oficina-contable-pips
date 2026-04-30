<x-app-layout>

    <x-ui.page-header
        :title="'Tipo de Trámite No. ' . request()->route('id')"
        description="Detalle y trámites asociados a este tipo.">
        <x-slot name="actions">
            <a href="{{ route('tipo-tramites.index') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:tipo-tramites.detalle :id="request()->route('id')" />
    <livewire:tipo-tramites.modal />

</x-app-layout>
