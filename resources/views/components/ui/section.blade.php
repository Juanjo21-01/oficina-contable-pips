@props([
    'title'       => null,
    'description' => null,
    'padding'     => true,
])

<div {{ $attributes->class([
    'bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 shadow-card',
]) }}>

    @if ($title || isset($headerActions))
        <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-slate-200 dark:border-slate-700">
            <div class="min-w-0">
                @if ($title)
                    <h2 class="text-base font-display font-semibold text-slate-800 dark:text-slate-200 truncate">
                        {{ $title }}
                    </h2>
                @endif
                @if ($description)
                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $description }}</p>
                @endif
            </div>
            @if (isset($headerActions))
                <div class="flex items-center gap-2 shrink-0">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div @class(['px-5 py-4' => $padding])>
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-b-lg">
            {{ $footer }}
        </div>
    @endif
</div>
