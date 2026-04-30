<x-app-layout>

    <x-ui.page-header title="Trámites" description="Gestión de trámites de la oficina contable.">
        <x-slot name="actions">
            <flux:button :href="route('tramites.crear')" variant="primary" icon="plus" wire:navigate>
                Nuevo trámite
            </flux:button>
        </x-slot>
    </x-ui.page-header>

    <livewire:tramites.tabla />
    <livewire:tramites.modal />

</x-app-layout>
