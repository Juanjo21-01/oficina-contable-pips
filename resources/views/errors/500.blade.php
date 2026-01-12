<!DOCTYPE html>
<html :class="{ 'dark': darkMode }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oficina Contable AFC - Error del Servidor</title>
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen bg-gray-50 dark:bg-gray-900">
    <main class="h-screen flex justify-center items-center">
        <div class="container flex flex-col items-center px-6 mx-auto">
            <div aria-label="Orange and tan hamster running in a metal wheel" class="wheel-and-hamster">
                <div class="wheel"></div>
                <div class="hamster">
                    <div class="hamster__body">
                        <div class="hamster__head">
                            <div class="hamster__ear"></div>
                            <div class="hamster__eye"></div>
                            <div class="hamster__nose"></div>
                        </div>
                        <div class="hamster__limb hamster__limb--fr"></div>
                        <div class="hamster__limb hamster__limb--fl"></div>
                        <div class="hamster__limb hamster__limb--br"></div>
                        <div class="hamster__limb hamster__limb--bl"></div>
                        <div class="hamster__tail"></div>
                    </div>
                </div>
                <div class="spoke"></div>
            </div>
            
            <h1 class="text-8xl font-bold text-orange-500">500</h1>
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-200">Error del Servidor</h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                Ocurrió un problema en el servidor.
            </p>
            <a href="{{ route('dashboard') }}" class="mt-6 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                <span>Volver al Inicio</span>
            </a>
        </div>
    </main>
</body>
</html>
