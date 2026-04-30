<footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700/60 text-slate-500 dark:text-slate-400 py-3 w-full shrink-0">
    <div class="container mx-auto px-4 lg:px-6">

        {{-- Desktop: 3 columnas --}}
        <div class="hidden md:flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <a href="{{ Auth::check() ? route('dashboard') : route('login') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 opacity-80 hover:opacity-100 transition-opacity">
                </a>
                <div>
                    <p class="text-sm font-semibold text-brand-600 dark:text-brand-400 leading-tight">Méndez García & Asociados</p>
                    @auth
                        <p class="text-xs text-slate-400 dark:text-slate-500">Gestión de Clientes y Trámites Fiscales</p>
                    @endauth
                </div>
            </div>

            <p class="text-xs text-slate-400 dark:text-slate-500">&copy; {{ date('Y') }} Todos los derechos reservados.</p>

            <p class="text-xs text-right">
                Desarrollado por
                <a href="https://www.linkedin.com/in/juan-jos%C3%A9-l%C3%B3pez-31a980216/"
                    target="_blank" rel="noopener noreferrer"
                    class="font-semibold text-brand-600 dark:text-brand-400 hover:underline transition-colors duration-150">
                    Juan José Hernández López
                </a>
            </p>
        </div>

        {{-- Móvil: línea única --}}
        <div class="flex md:hidden items-center justify-between gap-2">
            <p class="text-xs font-semibold text-brand-600 dark:text-brand-400">Méndez García & Asociados</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">&copy; {{ date('Y') }}</p>
        </div>

    </div>
</footer>
