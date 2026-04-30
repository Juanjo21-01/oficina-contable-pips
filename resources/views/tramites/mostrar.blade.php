<x-app-layout>

    <x-ui.page-header
        :title="'Trámite No. ' . request()->route('id')"
        description="Detalle completo del trámite.">
        <x-slot name="actions">
            <a href="{{ route('tramites.index') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver a trámites
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:tramites.detalle :id="request()->route('id')" />
    <livewire:tramites.modal />

</x-app-layout>
