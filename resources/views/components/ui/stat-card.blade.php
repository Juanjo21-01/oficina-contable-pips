@props([
    'label',
    'value',
    'icon'        => null,   // heroicon name e.g. 'users'
    'trend'       => null,   // numeric, positive = up, negative = down
    'trendLabel'  => null,   // e.g. 'vs mes anterior'
    'color'       => 'primary', // primary | brand | emerald | amber | rose
])

@php
    $colorMap = [
        'primary' => ['icon' => 'bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400'],
        'brand'   => ['icon' => 'bg-brand-100 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400'],
        'emerald' => ['icon' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
        'amber'   => ['icon' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],
        'rose'    => ['icon' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'],
    ];
    $iconClass = $colorMap[$color]['icon'] ?? $colorMap['primary']['icon'];

    $trendUp   = $trend !== null && $trend >= 0;
    $trendZero = $trend === null;
@endphp

<div {{ $attributes->class([
    'bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 shadow-card p-5',
    'flex items-start gap-4',
]) }}>

    @if ($icon)
        <div class="shrink-0 p-3 rounded-lg {{ $iconClass }}">
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6" />
        </div>
    @endif

    <div class="flex-1 min-w-0">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 truncate">
            {{ $label }}
        </p>
        <p class="mt-1 text-3xl font-display font-bold text-slate-900 dark:text-slate-100 tabular-nums leading-tight">
            {{ $value }}
        </p>

        @if (!$trendZero)
            <div class="mt-2 flex items-center gap-1 text-xs font-medium {{ $trendUp ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                @if ($trendUp)
                    <x-heroicon-o-arrow-trending-up class="w-3.5 h-3.5" />
                    <span>+{{ $trend }}%</span>
                @else
                    <x-heroicon-o-arrow-trending-down class="w-3.5 h-3.5" />
                    <span>{{ $trend }}%</span>
                @endif
                @if ($trendLabel)
                    <span class="text-slate-400 dark:text-slate-500 font-normal">{{ $trendLabel }}</span>
                @endif
            </div>
        @endif

        @if (isset($footer))
            <div class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
