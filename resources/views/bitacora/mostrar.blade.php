<x-app-layout>

    {{-- regresar --}}
    <a href="{{ route('bitacora') }}" wire:navigate
        class="flex items-center text-gray-600 dark:text-gray-400 hover:underline m-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Volver a la tabla de bitácoras</span>
    </a>

    <h1 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Bitácora No. {{ request()->route('id') }}
    </h1>

    <!-- Detalles -->
    <livewire:bitacora.detalle :id="request()->route('id')" />
</x-app-layout>
