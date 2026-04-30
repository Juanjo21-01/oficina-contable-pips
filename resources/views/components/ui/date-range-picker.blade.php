@props([
    'startModel' => 'fechaInicio',  // Livewire wire:model name
    'endModel'   => 'fechaFin',
    'startLabel' => 'Desde',
    'endLabel'   => 'Hasta',
])

<div {{ $attributes->class(['flex flex-col sm:flex-row items-end gap-3']) }}>
    <x-ui.form-field :label="$startLabel" class="flex-1">
        <flux:input
            type="date"
            wire:model.live="{{ $startModel }}"
            max="{{ now()->toDateString() }}"
        />
    </x-ui.form-field>

    <span class="hidden sm:block pb-2 text-slate-400 dark:text-slate-500 shrink-0">—</span>

    <x-ui.form-field :label="$endLabel" class="flex-1">
        <flux:input
            type="date"
            wire:model.live="{{ $endModel }}"
            max="{{ now()->toDateString() }}"
        />
    </x-ui.form-field>

    @if (isset($actions))
        <div class="pb-0.5 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
