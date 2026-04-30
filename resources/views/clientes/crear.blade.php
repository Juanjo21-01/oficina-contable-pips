<x-app-layout>

    <x-ui.page-header title="Nuevo cliente" description="Completa los datos para registrar un nuevo cliente.">
        <x-slot name="actions">
            <flux:button :href="route('clientes.index')" variant="ghost" icon="arrow-left" wire:navigate>
                Volver
            </flux:button>
        </x-slot>
    </x-ui.page-header>

    <livewire:clientes.formulario />

</x-app-layout>
