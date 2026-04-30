<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Oficina Contable "Méndez García & Asociados" {{ $metaTitle ?? '' }}</title>

    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">

    {{-- Pre-paint dark mode: aplica clase antes del primer paint para evitar FOUC --}}
    @include('layouts.partials.theme-init')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @include('layouts.partials.theme-controller')
</head>

<body class="h-screen overflow-hidden bg-slate-50 dark:bg-slate-950" x-data
    :class="{ 'overflow-hidden': $store.sidebar.isOpen }">

    <div class="flex h-full">

        {{-- Sidebar desktop --}}
        <livewire:layout.navigation />

        {{-- Mobile drawer + backdrop --}}
        <livewire:layout.navigationMobile />

        {{-- Main column --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            {{-- Header sticky --}}
            <livewire:layout.header />

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto">
                <div class="container px-6 mx-auto py-6">
                    {{ $slot }}
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <x-ui.toast-host />
    @fluxScripts
    @stack('scripts')
</body>

</html>
