<x-app-layout>
    <h1 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Reportes
    </h1>

    <livewire:reportes.tabla :filtrar="request()->query('filtrar', 'semana')" />

</x-app-layout>
