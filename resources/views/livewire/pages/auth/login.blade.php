<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: false);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Correo Electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Recuérdame -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sky-600 shadow-sm focus:ring-sky-500 dark:focus:ring-sky-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
            </label>
        </div>

        <!-- Botón -->
        <button
            class="block w-full px-4 py-2 mt-4 text-base font-medium leading-5 text-center text-white transition-colors duration-150 bg-sky-600 border border-transparent rounded-lg active:bg-sky-600 hover:bg-sky-700 focus:outline-none focus:shadow-outline-purple">
            {{ __('Iniciar Sesión') }}
        </button>

        <hr class="my-8" />

        <!-- Enlaces -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-sky-600 dark:text-sky-400 hover:underline"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif
        </div>
    </form>
</div>
