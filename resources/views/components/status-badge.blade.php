@props([
    'status',           // 1|0|'Activo'|'Inactivo'|'active'|'inactive'|'pending'|'completed'|'cancelled'
    'clickable' => false,
    'wireClick' => null,
])

@php
    $normalized = match(true) {
        in_array($status, [1, '1', 'Activo',    'active',    'activo'])    => 'active',
        in_array($status, [0, '0', 'Inactivo',  'inactive',  'inactivo'])  => 'inactive',
        in_array($status, ['Pendiente', 'pending', 'En proceso'])           => 'pending',
        in_array($status, ['Completado', 'completed', 'Finalizado'])        => 'active',
        in_array($status, ['Cancelado',  'cancelled', 'Anulado'])           => 'inactive',
        default => 'info',
    };

    $label = match($normalized) {
        'active'   => in_array($status, [1, '1']) ? 'Activo'   : ucfirst((string) $status),
        'inactive' => in_array($status, [0, '0']) ? 'Inactivo' : ucfirst((string) $status),
        'pending'  => ucfirst((string) $status),
        default    => ucfirst((string) $status),
    };

    $classes = match($normalized) {
        'active'   => 'badge-active',
        'inactive' => 'badge-inactive',
        'pending'  => 'badge-pending',
        default    => 'badge-info',
    };

    $dot = match($normalized) {
        'active'   => 'bg-brand-500',
        'inactive' => 'bg-rose-500',
        'pending'  => 'bg-amber-500',
        default    => 'bg-blue-500',
    };
@endphp

@if ($clickable && $wireClick)
    <button
        wire:click="{{ $wireClick }}"
        title="Cambiar estado"
        class="{{ $classes }} cursor-pointer hover:opacity-80 transition-opacity duration-150"
    >
        <span class="w-1.5 h-1.5 rounded-full {{ $dot }} mr-1.5 inline-block"></span>
        {{ $label }}
    </button>
@else
    <span class="{{ $classes }}">
        <span class="w-1.5 h-1.5 rounded-full {{ $dot }} mr-1.5 inline-block"></span>
        {{ $label }}
    </span>
@endif
