<!DOCTYPE html>
<html :class="{ 'dark': darkMode }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Oficina Contable AFC</title>

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

<body>
    <div class="flex items-center min-h-screen py-4 px-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
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
                            <img src="/img/logo.png" alt="Logo AFC" class="w-40 mx-auto mb-3">
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
</body>

</html>
