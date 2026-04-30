<x-app-layout>

    <x-ui.page-header
        :title="'Tipo de Cliente No. ' . request()->route('id')"
        description="Detalle y clientes asociados a este tipo.">
        <x-slot name="actions">
            <a href="{{ route('tipo-clientes.index') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:tipo-clientes.detalle :id="request()->route('id')" />

</x-app-layout>
