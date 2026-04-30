@props(['size' => 'md'])

@php
    $sizes = ['sm' => 'w-12', 'md' => 'w-20', 'lg' => 'w-28'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<a href="{{ Auth::check() ? route('dashboard') : route('login') }}" wire:navigate>
    <img src="{{ asset('img/logo.png') }}"
         alt="Logo Méndez García & Asociados"
         class="{{ $sizeClass }} transition-opacity hover:opacity-80">
</a>
