@props([
    'label',
    'for'         => null,
    'helper'      => null,
    'required'    => false,
    'error'       => null,    // explicit error string (optional — flux:error handles wire models)
])

<div {{ $attributes->class(['space-y-1.5']) }}>
    @if (isset($label) || $label ?? false)
        <label
            @if ($for) for="{{ $for }}" @endif
            class="block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500 ml-0.5" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <p class="text-xs text-rose-600 dark:text-rose-400 flex items-center gap-1">
            <x-heroicon-o-exclamation-circle class="w-3.5 h-3.5 shrink-0" />
            {{ $error }}
        </p>
    @endif

    @if ($helper && !$error)
        <p class="text-xs text-slate-400 dark:text-slate-500">{{ $helper }}</p>
    @endif
</div>
