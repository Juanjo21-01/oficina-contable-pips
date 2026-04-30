<x-app-layout>

    <x-ui.page-header
        :title="'Usuario No. ' . request()->route('id')"
        description="Perfil y actividad del usuario.">
        <x-slot name="actions">
            <a href="{{ route('usuarios.index') }}" wire:navigate class="btn-secondary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver
            </a>
        </x-slot>
    </x-ui.page-header>

    <livewire:usuarios.detalle :id="request()->route('id')" />
    <livewire:usuarios.modal />

</x-app-layout>
