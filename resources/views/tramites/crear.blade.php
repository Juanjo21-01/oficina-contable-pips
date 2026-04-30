<x-app-layout>

    <x-ui.page-header title="Crear Trámite" description="Registra un nuevo trámite para un cliente.">
        <x-slot name="actions">
            <a href="{{ route('tramites.index') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:tramites.formulario />

</x-app-layout>
