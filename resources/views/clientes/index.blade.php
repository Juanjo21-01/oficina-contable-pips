<x-app-layout>

    <x-ui.page-header title="Clientes" description="Gestión de clientes de la oficina contable.">
        <x-slot name="actions">
            <flux:button :href="route('clientes.crear')" variant="primary" icon="plus" wire:navigate>
                Nuevo cliente
            </flux:button>
        </x-slot>
    </x-ui.page-header>

    <livewire:clientes.tabla />

    <livewire:clientes.modal />

</x-app-layout>
