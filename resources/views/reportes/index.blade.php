<x-app-layout>

    <x-ui.page-header title="Reportes" description="Consulta y descarga reportes de trámites por período." />

    <livewire:reportes.tabla :filtrar="request()->query('filtrar', 'semana')" />

</x-app-layout>
