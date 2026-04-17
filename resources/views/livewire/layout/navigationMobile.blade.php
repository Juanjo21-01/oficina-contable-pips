<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

{{-- Backdrop with blur --}}
<div x-show="isSideMenuOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="closeSideMenu"
    class="fixed inset-0 z-10 bg-gray-900/50 backdrop-blur-sm lg:hidden"
    aria-hidden="true">
</div>

<aside
    class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 lg:hidden"
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 -translate-x-full"
    @keydown.escape.window="closeSideMenu">

    <div class="flex flex-col h-full py-4 text-zinc-500 dark:text-zinc-400 overflow-y-auto">

        {{-- Header: logo + close button --}}
        <div class="flex items-center justify-between px-4 mb-4">
            <a href="{{ route('dashboard') }}" @click="closeSideMenu">
                <img src="/img/logo.png" alt="Logo Méndez García & Asociados" class="w-16">
            </a>
            <button @click="closeSideMenu"
                class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors duration-150"
                aria-label="Cerrar menú">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Nav items --}}
        <nav class="flex-1 px-3 space-y-1">

            {{-- Inicio --}}
            @php $dashActive = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}" wire:navigate @click="closeSideMenu"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                    {{ $dashActive
                        ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Inicio
            </a>

            {{-- Admin section --}}
            @if (Auth::user()->role->nombre == 'Administrador')
                <div class="pt-3 pb-1 px-3">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Administración</p>
                </div>

                @php $usersActive = request()->routeIs('roles') || request()->routeIs('usuarios.index') || request()->routeIs('usuarios.mostrar'); @endphp
                <div x-data="{ open: {{ $usersActive ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                            {{ $usersActive ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Usuarios
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                        <li><a href="{{ route('roles') }}" wire:navigate @click="closeSideMenu"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('roles') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            Roles
                        </a></li>
                        <li><a href="{{ route('usuarios.index') }}" wire:navigate @click="closeSideMenu"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('usuarios.index') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                            Usuarios
                        </a></li>
                    </ul>
                </div>
            @endif

            {{-- Gestión --}}
            <div class="pt-3 pb-1 px-3">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Gestión</p>
            </div>

            {{-- Trámites --}}
            @php $tramitesActive = request()->routeIs('tipo-tramites.index') || request()->routeIs('tipo-tramites.mostrar') || request()->routeIs('tramites.index') || request()->routeIs('tramites.crear') || request()->routeIs('tramites.mostrar'); @endphp
            <div x-data="{ open: {{ $tramitesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $tramitesActive ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
                        Trámites
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    <li><a href="{{ route('tipo-tramites.index') }}" wire:navigate @click="closeSideMenu" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tipo-tramites.index') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg>Tipo de Trámites</a></li>
                    <li><a href="{{ route('tramites.index') }}" wire:navigate @click="closeSideMenu" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tramites.index') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>Trámites</a></li>
                </ul>
            </div>

            {{-- Clientes --}}
            @php $clientesActive = request()->routeIs('tipo-clientes.index') || request()->routeIs('tipo-clientes.mostrar') || request()->routeIs('clientes.index') || request()->routeIs('clientes.crear') || request()->routeIs('clientes.mostrar'); @endphp
            <div x-data="{ open: {{ $clientesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $clientesActive ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        Clientes
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    <li><a href="{{ route('tipo-clientes.index') }}" wire:navigate @click="closeSideMenu" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tipo-clientes.index') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg>Tipo de Clientes</a></li>
                    <li><a href="{{ route('clientes.index') }}" wire:navigate @click="closeSideMenu" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('clientes.index') ? 'text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>Clientes</a></li>
                </ul>
            </div>

            {{-- Reportes --}}
            <div class="pt-3 pb-1 px-3">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Reportes</p>
            </div>

            @php $reportesActive = request()->routeIs('reportes.index'); @endphp
            <div x-data="{ open: {{ $reportesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $reportesActive ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                        Reportes
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    @foreach([['filtrar'=>'semana','label'=>'Por Semana'],['filtrar'=>'mes','label'=>'Por Mes'],['filtrar'=>'rango','label'=>'Por Rango']] as $rep)
                        <li><a href="{{ route('reportes.index', ['filtrar' => $rep['filtrar']]) }}" wire:navigate @click="closeSideMenu" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 hover:bg-gray-100 dark:hover:bg-gray-700">{{ $rep['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Bitácora --}}
            @if (Auth::user()->role->nombre == 'Administrador')
                @php $bitacoraActive = request()->routeIs('bitacora'); @endphp
                <a href="{{ route('bitacora') }}" wire:navigate @click="closeSideMenu"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $bitacoraActive ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                    Bitácora
                </a>
            @endif

        </nav>

        {{-- Bottom: user + logout --}}
        <div class="mt-auto px-3 pt-4 border-t border-gray-100 dark:border-gray-700 space-y-1">
            @php
                $initials = strtoupper(substr(Auth::user()->nombres, 0, 1) . substr(Auth::user()->apellidos ?? '', 0, 1));
                $colors = ['bg-brand-600','bg-purple-600','bg-rose-600','bg-amber-600','bg-blue-600'];
                $color  = $colors[crc32(Auth::user()->nombres) % count($colors)];
            @endphp
            <div class="flex items-center gap-3 px-2 py-2">
                <span class="avatar {{ $color }} text-white">{{ $initials }}</span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 truncate">{{ Auth::user()->nombres }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->role->nombre }}</p>
                </div>
            </div>
            <button wire:click="logout"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
                Cerrar Sesión
            </button>
        </div>

    </div>
</aside>
