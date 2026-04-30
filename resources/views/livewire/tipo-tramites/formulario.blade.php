<div>
    <form wire:submit.prevent="guardar" id="tipo-tramite-form" autocomplete="off">

        @if ($errorMessage)
            <div class="flex items-center gap-2 px-4 py-3 mb-4 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 text-sm">
                <x-heroicon-o-exclamation-circle class="w-4 h-4 shrink-0" />
                {{ $errorMessage }}
            </div>
        @endif

        <x-ui.form-field label="Nombre" for="tipo-nombre" required :error="$errors->first('nombre')">
            <input wire:model="nombre" id="tipo-nombre" type="text"
                class="form-input-base py-2 px-3 {{ $errors->has('nombre') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : '' }}"
                wire:keydown="clearError('nombre')" autofocus />
        </x-ui.form-field>

    </form>
</div>
