@props([
    'message'     => 'No hay registros que mostrar.',
    'subMessage'  => null,
    'actionLabel' => null,
    'actionRoute' => null,
    'actionEvent' => null,  // wire:click if no route
    'icon'        => 'table', // table|users|document|search
])

@php
    $icons = [
        'table' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0c0 .621.504 1.125 1.125 1.125h15M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125H9.375m2.625-1.125c0 .621.504 1.125 1.125 1.125h1.5m-3.75 3.75v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125H9.375m2.625-1.125c0 .621.504 1.125 1.125 1.125h1.5m-6.75 3.75v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125H4.875m2.625-1.125c0 .621.504 1.125 1.125 1.125h1.5M18 12.75v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125H15.375m2.625-1.125c0 .621.504 1.125 1.125 1.125h.375"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
        'document' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>',
        'search' => '<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>',
    ];
    $iconPath = $icons[$icon] ?? $icons['table'];
@endphp

<div class="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
        stroke="currentColor" class="w-14 h-14 mb-4 opacity-30">
        {!! $iconPath !!}
    </svg>

    <p class="text-base font-semibold text-gray-500 dark:text-gray-400">{{ $message }}</p>

    @if ($subMessage)
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ $subMessage }}</p>
    @endif

    @if ($actionLabel && $actionRoute)
        <a href="{{ $actionRoute }}"
            class="btn-primary mt-4 text-sm"
            wire:navigate>
            {{ $actionLabel }}
        </a>
    @elseif ($actionLabel && $actionEvent)
        <button wire:click="{{ $actionEvent }}"
            class="btn-primary mt-4 text-sm">
            {{ $actionLabel }}
        </button>
    @endif
</div>
