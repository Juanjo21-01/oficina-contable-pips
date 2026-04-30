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

<header
    class="sticky top-0 z-10 h-16 flex items-center bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700/60 shadow-sm">
    <div class="flex items-center justify-between w-full px-4 lg:px-6">

        {{-- Izquierda: hamburger (móvil) + breadcrumb --}}
        <div class="flex items-center gap-3">

            {{-- Hamburger móvil --}}
            <button
                class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-150 lg:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/60"
                @click="$store.sidebar.toggle()" aria-label="Abrir menú">
                <x-heroicon-o-bars-3 class="w-5 h-5" />
            </button>

            {{-- Breadcrumb --}}
            <x-breadcrumb />
        </div>

        {{-- Derecha: toggle tema + menú usuario --}}
        <div class="flex items-center gap-2">

            {{-- Theme toggle —— usa Alpine.store('theme') para persistir entre wire:navigate --}}
            <button
                class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/60"
                @click="$store.theme.toggle()"
                :aria-label="$store.theme.isDark ? 'Activar modo claro' : 'Activar modo oscuro'">
                <template x-if="!$store.theme.isDark">
                    <x-heroicon-o-moon class="w-5 h-5" />
                </template>
                <template x-if="$store.theme.isDark">
                    <x-heroicon-o-sun class="w-5 h-5" />
                </template>
            </button>

            {{-- Menú usuario --}}
            <flux:dropdown position="bottom" align="end">

                <button
                    class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/60">
                    <x-ui.user-avatar class="text-xs" />
                    <span
                        class="hidden sm:block text-sm font-medium text-slate-700 dark:text-slate-300 max-w-[120px] truncate"
                        x-data="{{ json_encode(['name' => auth()->user()->nombres]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                    </span>
                    <x-heroicon-s-chevron-down class="w-4 h-4 text-slate-400 shrink-0" />
                </button>

                <flux:menu class="min-w-[220px]">

                    {{-- Info del usuario --}}
                    <div class="px-3 py-2.5 border-b border-slate-100 dark:border-slate-700">
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">
                            {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        <span class="badge-info mt-1 text-xs">{{ Auth::user()->role->nombre }}</span>
                    </div>

                    <flux:menu.item icon="user" :href="route('profile')" wire:navigate>
                        Mi Perfil
                    </flux:menu.item>

                    <flux:menu.item icon="light-bulb" :href="asset('manual/Manual de Usuario.pdf')" target="_blank"
                        rel="noopener noreferrer">
                        Manual de Usuario
                    </flux:menu.item>

                    <flux:menu.separator />

                    <flux:menu.item wire:click="logout"
                        class="text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300">
                        Cerrar Sesión
                    </flux:menu.item>

                </flux:menu>
            </flux:dropdown>

        </div>
    </div>
</header>
