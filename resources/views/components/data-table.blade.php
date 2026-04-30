@props([
    'columns'      => [],
    'emptyMessage' => 'No hay registros que mostrar.',
    'skeletonRows' => 5,
    'colspan'      => null,
])

@php
    $cols = $colspan ?? count($columns);
@endphp

<div {{ $attributes }}>

    {{-- Toolbar: search, filters, bulk actions --}}
    @isset($toolbar)
        <div class="toolbar">
            {{ $toolbar }}
        </div>
    @endisset

    <div class="table-container mb-4">
        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-full table-auto whitespace-nowrap">

                {{-- Head --}}
                <thead>
                    <tr>
                        @foreach ($columns as $col)
                            <th class="table-header {{ $col['width'] ?? '' }} {{ isset($col['align']) && $col['align'] === 'left' ? 'text-left' : '' }}">
                                {{ $col['label'] }}
                            </th>
                        @endforeach
                        @isset($headExtra)
                            {{ $headExtra }}
                        @endisset
                    </tr>
                </thead>

                {{-- Skeleton: shows during loading (after 200ms delay) --}}
                <tbody wire:loading.delay
                       class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    @for ($i = 0; $i < $skeletonRows; $i++)
                        <tr>
                            @for ($j = 0; $j < $cols; $j++)
                                <td class="table-cell">
                                    <div class="skeleton h-4 rounded {{ $j === 0 ? 'w-8 mx-auto' : ($j === $cols - 1 ? 'w-20 mx-auto' : 'w-full max-w-[160px] mx-auto') }}"></div>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>

                {{-- Real rows: hidden during loading --}}
                <tbody wire:loading.remove
                       class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-700">
                    {{ $slot }}
                </tbody>

            </table>
        </div>

        {{-- Pagination slot --}}
        @isset($pagination)
            {{ $pagination }}
        @endisset
    </div>

    {{-- Empty state slot --}}
    @isset($empty)
        {{ $empty }}
    @endisset

</div>
