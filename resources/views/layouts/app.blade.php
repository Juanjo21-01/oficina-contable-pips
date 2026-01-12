<!DOCTYPE html>
<html :class="{ 'dark': darkMode }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Oficina Contable AFC {{ $metaTitle ?? '' }}</title>

    <!-- Icon -->
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">

    <!-- Fonts -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function data() {
            function getThemeFromLocalStorage() {
                if (window.localStorage.getItem("dark")) {
                    return JSON.parse(window.localStorage.getItem("dark"));
                }
                return (
                    !!window.matchMedia &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches
                );
            }

            function setThemeToLocalStorage(value) {
                window.localStorage.setItem("dark", value);
            }

            return {
                darkMode: getThemeFromLocalStorage(),
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    setThemeToLocalStorage(this.darkMode);
                },
                isSideMenuOpen: false,
                toggleSideMenu() {
                    this.isSideMenuOpen = !this.isSideMenuOpen;
                },
                closeSideMenu() {
                    this.isSideMenuOpen = false;
                },
                isProfileMenuOpen: false,
                toggleProfileMenu() {
                    this.isProfileMenuOpen = !this.isProfileMenuOpen;
                },
                closeProfileMenu() {
                    this.isProfileMenuOpen = false;
                },
                isPagesMenuOpen: false,
                togglePagesMenu() {
                    this.isPagesMenuOpen = !this.isPagesMenuOpen;
                },
                isPagesMenuUsuariosOpen: false,
                togglePagesMenuUsuarios() {
                    this.isPagesMenuUsuariosOpen = !this.isPagesMenuUsuariosOpen;
                },
                isPagesMenuTramitesOpen: false,
                togglePagesMenuTramites() {
                    this.isPagesMenuTramitesOpen = !this.isPagesMenuTramitesOpen;
                },
                isPagesMenuClientesOpen: false,
                togglePagesMenuClientes() {
                    this.isPagesMenuClientesOpen = !this.isPagesMenuClientesOpen;
                },
                isModalOpen: false,
                trapCleanup: null,
                openModal() {
                    this.isModalOpen = true;
                    this.trapCleanup = focusTrap(document.querySelector("#modal"));
                },
                closeModal() {
                    this.isModalOpen = false;
                    this.trapCleanup();
                },
            };
        }
    </script>
</head>

<body class="overflow-hidden h-screen" :class="{ 'overflow-hidden': isSideMenuOpen }">
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <div class="flex flex-1">
            <!-- Navegación -->
            <livewire:layout.navigation />
            <!-- Backdrop -->
            <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            </div>
            <livewire:layout.navigationMobile />

            <div class="flex flex-col flex-1 w-full overflow-hidden">
                <!-- Encabezado -->
                <livewire:layout.header />

                <!-- Contenido -->
                <main class="h-full overflow-y-auto flex-grow">
                    <div class="container px-6 mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>

</html>
