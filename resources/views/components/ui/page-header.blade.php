@props([
    'title',
    'description' => null,
])

<div {{ $attributes->class(['flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6']) }}>
    <div class="min-w-0">
        <h1 class="text-2xl sm:text-3xl font-display font-semibold text-slate-900 dark:text-slate-100 leading-tight truncate">
            {{ $title }}
        </h1>
        @if ($description)
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                {{ $description }}
            </p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex items-center gap-2 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
