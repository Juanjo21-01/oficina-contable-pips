<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Oficina Contable "Méndez García & Asociados"</title>

    <!-- Icon -->
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">

    <!-- Pre-paint dark mode: aplica clase antes de que el navegador pinte para evitar FOUC -->
    @include('layouts.partials.theme-init')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @include('layouts.partials.theme-controller')
</head>

<body>
    <div class="flex items-center min-h-screen py-4 px-6 bg-slate-50 dark:bg-slate-950">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-slate-900">
            <div class="flex flex-col overflow-y-auto md:flex-row">

                <!-- Imagen del lado izquierdo -->
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full" src="/img/fondo-login.jpeg"
                        alt="Fondo Inicio de Sesión" />
                </div>

                <!-- Formulario del lado derecho -->
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <!-- Logotipo -->
                        <div class="mb-3 text-center">
                            <img src="/img/logo.png" alt="Logo Méndez García & Asociados" class="w-40 mx-auto mb-3">
                        </div>

                        <!-- Formulario de inicio de sesión -->
                        <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>
    @fluxScripts
</body>

</html>
