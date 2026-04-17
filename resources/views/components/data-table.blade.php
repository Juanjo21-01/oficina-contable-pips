@props([
    'columns'      => [],        // array of ['label' => 'Nombre', 'width' => 'w-3/12', 'align' => 'center']
    'emptyMessage' => 'No hay registros que mostrar.',
    'emptyAction'  => null,      // ['label' => '+ Agregar', 'route' => '#'] or null
    'skeletonRows' => 5,
    'colspan'      => null,      // auto-calculated from columns if null
])

@php
    $cols = $colspan ?? count($columns);
@endphp

<div class="table-container mb-4">
    <div class="w-full overflow-x-auto">
        <table class="w-full min-w-full table-auto whitespace-nowrap">

            {{-- Head --}}
            <thead>
                <tr>
                    @foreach ($columns as $col)
                        <th class="table-header {{ $col['width'] ?? '' }}">
                            {{ $col['label'] }}
                        </th>
                    @endforeach
                    @if (isset($headExtra))
                        {{ $headExtra }}
                    @endif
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="bg-white divide-y divide-gray-100 dark:divide-gray-700 dark:bg-gray-800">

                {{-- Loading skeleton (shown via wire:loading) --}}
                <tr wire:loading.delay class="hidden">
                    <td colspan="{{ $cols }}">
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @for ($i = 0; $i < $skeletonRows; $i++)
                                <div class="flex items-center gap-4 px-4 py-3">
                                    <div class="skeleton h-4 w-8 rounded"></div>
                                    <div class="skeleton h-4 flex-1 rounded"></div>
                                    <div class="skeleton h-4 w-20 rounded"></div>
                                    <div class="skeleton h-4 w-16 rounded"></div>
                                    <div class="skeleton h-6 w-16 rounded-full"></div>
                                    <div class="skeleton h-4 w-20 rounded"></div>
                                </div>
                            @endfor
                        </div>
                    </td>
                </tr>

                {{-- Actual rows slot --}}
                <tr wire:loading.remove class="hidden"></tr>
                {{ $slot }}

            </tbody>
        </table>
    </div>

    {{-- Pagination slot --}}
    @isset($pagination)
        {{ $pagination }}
    @endisset
</div>

{{-- Empty state (rendered outside table for better layout control) --}}
@isset($empty)
    {{ $empty }}
@else
    {{-- Default empty state shown when slot has no rows — blade can't detect this directly,
         so tables should use @if($items->isEmpty()) to conditionally include this. --}}
@endisset
