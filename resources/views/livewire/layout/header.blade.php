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

<header class="z-10 h-16 flex items-center bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <div class="flex items-center justify-between w-full px-4 lg:px-6">

        {{-- Left: hamburger (mobile) + breadcrumb --}}
        <div class="flex items-center gap-3">
            {{-- Mobile hamburger --}}
            <button
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-brand-600 dark:hover:text-brand-400 transition-colors duration-150 lg:hidden focus:outline-none focus:ring-2 focus:ring-brand-500"
                @click="toggleSideMenu"
                aria-label="Abrir menú">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <x-breadcrumb />
        </div>

        {{-- Right: theme toggle + user dropdown --}}
        <div class="flex items-center gap-2">

            {{-- Theme toggle --}}
            <button
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-brand-600 dark:hover:text-brand-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-brand-500"
                @click="toggleTheme"
                :aria-label="darkMode ? 'Activar modo claro' : 'Activar modo oscuro'">
                <template x-if="!darkMode">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </template>
                <template x-if="darkMode">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd" />
                    </svg>
                </template>
            </button>

            {{-- User dropdown --}}
            <x-dropdown align="right" width="52">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        {{-- Avatar initials --}}
                        @php
                            $initials = strtoupper(substr(Auth::user()->nombres, 0, 1) . substr(Auth::user()->apellidos ?? '', 0, 1));
                            $colors = ['bg-brand-600','bg-purple-600','bg-rose-600','bg-amber-600','bg-blue-600'];
                            $color  = $colors[crc32(Auth::user()->nombres) % count($colors)];
                        @endphp
                        <span class="avatar {{ $color }} text-white text-xs">{{ $initials }}</span>

                        <span
                            class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300 max-w-[120px] truncate"
                            x-data="{{ json_encode(['name' => auth()->user()->nombres]) }}"
                            x-text="name"
                            x-on:profile-updated.window="name = $event.detail.name">
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 text-gray-400 shrink-0">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    {{-- User info header --}}
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                            {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        <span class="badge-info mt-1 text-xs">{{ Auth::user()->role->nombre }}</span>
                    </div>

                    {{-- Links --}}
                    <x-dropdown-link :href="route('profile')" wire:navigate class="hover:text-brand-600">
                        <svg class="w-4 h-4 mr-3 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Mi Perfil
                    </x-dropdown-link>

                    <x-dropdown-link :href="asset('manual/Manual de Usuario.pdf')" target="_blank" rel="noopener noreferrer" class="hover:text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 mr-3 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                        Manual de Usuario
                    </x-dropdown-link>

                    <div class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="hover:text-rose-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                </svg>
                                Cerrar Sesión
                            </x-dropdown-link>
                        </button>
                    </div>
                </x-slot>
            </x-dropdown>

        </div>
    </div>
</header>
