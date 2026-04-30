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

<div>

{{-- Backdrop --}}
<div
    x-show="$store.sidebar.isOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$store.sidebar.close()"
    class="fixed inset-0 z-10 bg-slate-900/60 backdrop-blur-sm lg:hidden"
    aria-hidden="true">
</div>

<aside
    class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-700/60 lg:hidden"
    x-show="$store.sidebar.isOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 -translate-x-full"
    @keydown.escape.window="$store.sidebar.close()">

    <div class="flex flex-col h-full py-4 text-slate-500 dark:text-slate-400 overflow-y-auto">

        {{-- Header: logo + cerrar --}}
        <div class="flex items-center justify-between px-4 mb-4">
            <a href="{{ route('dashboard') }}" @click="$store.sidebar.close()">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Méndez García & Asociados" class="w-16 transition-opacity hover:opacity-80">
            </a>
            <button @click="$store.sidebar.close()"
                class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-colors duration-150"
                aria-label="Cerrar menú">
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>
        </div>

        {{-- Nav items --}}
        <nav class="flex-1 px-3 space-y-0.5">

            {{-- Inicio --}}
            @php $dashActive = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}" wire:navigate @click="$store.sidebar.close()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                    {{ $dashActive
                        ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300'
                        : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                <x-heroicon-o-home class="w-5 h-5 shrink-0" />
                Inicio
            </a>

            {{-- Administración (solo admin) --}}
            @if (Auth::user()->role->nombre == 'Administrador')
                <div class="pt-4 pb-1 px-3">
                    <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Administración</p>
                </div>

                @php $usersActive = request()->routeIs('roles') || request()->routeIs('usuarios.index') || request()->routeIs('usuarios.mostrar'); @endphp
                <div x-data="{ open: {{ $usersActive ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                            {{ $usersActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                        <span class="flex items-center gap-3">
                            <x-heroicon-o-users class="w-5 h-5 shrink-0" />
                            Usuarios
                        </span>
                        <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform duration-200" ::class="open ? 'rotate-180' : ''" />
                    </button>
                    <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                        <li>
                            <a href="{{ route('roles') }}" wire:navigate @click="$store.sidebar.close()"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('roles') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                                <x-heroicon-o-shield-check class="w-4 h-4 shrink-0" />
                                Roles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('usuarios.index') }}" wire:navigate @click="$store.sidebar.close()"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('usuarios.index') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                                <x-heroicon-o-user class="w-4 h-4 shrink-0" />
                                Usuarios
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Gestión --}}
            <div class="pt-4 pb-1 px-3">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Gestión</p>
            </div>

            {{-- Trámites --}}
            @php $tramitesActive = request()->routeIs('tipo-tramites.index') || request()->routeIs('tipo-tramites.mostrar') || request()->routeIs('tramites.index') || request()->routeIs('tramites.crear') || request()->routeIs('tramites.mostrar'); @endphp
            <div x-data="{ open: {{ $tramitesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $tramitesActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                    <span class="flex items-center gap-3">
                        <x-heroicon-o-document-text class="w-5 h-5 shrink-0" />
                        Trámites
                    </span>
                    <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform duration-200" ::class="open ? 'rotate-180' : ''" />
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    <li>
                        <a href="{{ route('tipo-tramites.index') }}" wire:navigate @click="$store.sidebar.close()"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tipo-tramites.index') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <x-heroicon-o-briefcase class="w-4 h-4 shrink-0" />
                            Tipo de Trámites
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tramites.index') }}" wire:navigate @click="$store.sidebar.close()"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tramites.index') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <x-heroicon-o-document-text class="w-4 h-4 shrink-0" />
                            Trámites
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Clientes --}}
            @php $clientesActive = request()->routeIs('tipo-clientes.index') || request()->routeIs('tipo-clientes.mostrar') || request()->routeIs('clientes.index') || request()->routeIs('clientes.crear') || request()->routeIs('clientes.mostrar'); @endphp
            <div x-data="{ open: {{ $clientesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $clientesActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                    <span class="flex items-center gap-3">
                        <x-heroicon-o-user-group class="w-5 h-5 shrink-0" />
                        Clientes
                    </span>
                    <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform duration-200" ::class="open ? 'rotate-180' : ''" />
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    <li>
                        <a href="{{ route('tipo-clientes.index') }}" wire:navigate @click="$store.sidebar.close()"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('tipo-clientes.index') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <x-heroicon-o-tag class="w-4 h-4 shrink-0" />
                            Tipo de Clientes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.index') }}" wire:navigate @click="$store.sidebar.close()"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('clientes.index') ? 'text-primary-700 dark:text-primary-300 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <x-heroicon-o-user-group class="w-4 h-4 shrink-0" />
                            Clientes
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Reportes --}}
            <div class="pt-4 pb-1 px-3">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Reportes</p>
            </div>

            @php $reportesActive = request()->routeIs('reportes.index'); @endphp
            <div x-data="{ open: {{ $reportesActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $reportesActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                    <span class="flex items-center gap-3">
                        <x-heroicon-o-chart-bar class="w-5 h-5 shrink-0" />
                        Reportes
                    </span>
                    <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform duration-200" ::class="open ? 'rotate-180' : ''" />
                </button>
                <ul x-show="open" x-collapse class="mt-1 ml-8 space-y-0.5">
                    @foreach([['filtrar'=>'semana','label'=>'Por Semana'],['filtrar'=>'mes','label'=>'Por Mes'],['filtrar'=>'rango','label'=>'Por Rango']] as $rep)
                        <li>
                            <a href="{{ route('reportes.index', ['filtrar' => $rep['filtrar']]) }}" wire:navigate @click="$store.sidebar.close()"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100">
                                <x-heroicon-o-chart-bar class="w-4 h-4 shrink-0" />
                                {{ $rep['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Bitácora (solo admin) --}}
            @if (Auth::user()->role->nombre == 'Administrador')
                @php $bitacoraActive = request()->routeIs('bitacora'); @endphp
                <a href="{{ route('bitacora') }}" wire:navigate @click="$store.sidebar.close()"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150
                        {{ $bitacoraActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                    <x-heroicon-o-book-open class="w-5 h-5 shrink-0" />
                    Bitácora
                </a>
            @endif

        </nav>

        {{-- Bottom: usuario + logout --}}
        <div class="mt-auto px-3 pt-4 border-t border-slate-200 dark:border-slate-700/60 space-y-1">
            <div class="flex items-center gap-3 px-2 py-2">
                <x-ui.user-avatar />
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 truncate">{{ Auth::user()->nombres }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->role->nombre }}</p>
                </div>
            </div>
            <button wire:click="logout"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors duration-150">
                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 shrink-0" />
                Cerrar Sesión
            </button>
        </div>

    </div>
</aside>

</div>
