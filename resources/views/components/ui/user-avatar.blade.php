@props(['user' => null])

@php
    $u = $user ?? Auth::user();
    $initials = strtoupper(
        substr($u->nombres, 0, 1) . substr($u->apellidos ?? '', 0, 1)
    );
    $palette = ['bg-brand-600', 'bg-purple-600', 'bg-rose-600', 'bg-amber-600', 'bg-blue-600'];
    $color = $palette[crc32($u->nombres) % count($palette)];
@endphp

<span {{ $attributes->merge(['class' => "avatar {$color} text-white"]) }}>{{ $initials }}</span>
