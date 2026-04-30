@props([])

<kbd {{ $attributes->class([
    'inline-flex items-center justify-center px-1.5 py-0.5 min-w-[1.5rem]',
    'rounded border border-slate-300 dark:border-slate-600',
    'bg-slate-100 dark:bg-slate-700',
    'text-xs font-mono font-semibold text-slate-600 dark:text-slate-300',
    'shadow-[inset_0_-1px_0_0] shadow-slate-300 dark:shadow-slate-600',
]) }}>{{ $slot }}</kbd>
