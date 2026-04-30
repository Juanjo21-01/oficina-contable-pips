<x-app-layout>

    <x-ui.page-header title="Detalle del cliente" description="Información completa, agencia virtual y trámites.">
        <x-slot name="actions">
            <flux:button :href="route('clientes.index')" variant="ghost" icon="arrow-left" wire:navigate>
                Volver a clientes
            </flux:button>
        </x-slot>
    </x-ui.page-header>

    <livewire:clientes.detalle :id="request()->route('id')" />

    <livewire:clientes.modal />

</x-app-layout>
