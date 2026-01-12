<footer class="bg-white shadow-md dark:bg-gray-800 text-gray-700 dark:text-gray-300 py-2 w-full">
    <div class="container mx-auto px-4 lg:px-8 flex flex-col md:flex-row justify-between items-center">
        <div class="flex items-center gap-3 text-center md:text-left md:order-1">
            <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="hidden md:inline-block">
                <img src="{{ asset('img/logo.png') }}" alt="Logo AFC" class="w-20">
            </a>
            <div>
                <h5 class="text-lg font-semibold text-teal-500 dark:text-teal-300">AFC Asesoría Fiscal Contable</h5>
                @auth
                    <p class="text-sm">Sistema de Gestión de Clientes y Trámites Fiscales</p>
                @endauth
            </div>
        </div>

        <div class="text-center mt-3 md:mt-0 order-2 md:order-1">
            <p class="text-sm">
                &copy; {{ date('Y') }} Todos los derechos reservados.
            </p>
        </div>

        <div class="text-center md:text-right mt-3 md:mt-0 md:order-1">
            <p class="text-sm">Desarrollado por:</p>
            <p class="text-sm font-semibold text-teal-500 dark:text-teal-300">
                <a href="https://www.linkedin.com/in/juan-jos%C3%A9-l%C3%B3pez-31a980216/" target="_blank"
                    rel="noopener noreferrer"
                    class="hover:underline hover:text-teal-500 dark:hover:text-teal-400 transition duration-300">
                    Juan José Hernández López
                </a>
            </p>
        </div>
    </div>
</footer>
