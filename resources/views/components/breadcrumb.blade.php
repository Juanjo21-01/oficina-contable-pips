@php
    $segments = [
        'dashboard'          => ['label' => 'Inicio',            'icon' => 'home'],
        'clientes'           => ['label' => 'Clientes',          'icon' => 'users'],
        'tramites'           => ['label' => 'Trámites',          'icon' => 'document'],
        'usuarios'           => ['label' => 'Usuarios',          'icon' => 'users'],
        'roles'              => ['label' => 'Roles',             'icon' => 'shield'],
        'reportes'           => ['label' => 'Reportes',          'icon' => 'chart'],
        'bitacora'           => ['label' => 'Bitácora',          'icon' => 'book'],
        'tipo-clientes'      => ['label' => 'Tipo de Clientes',  'icon' => 'tag'],
        'tipo-tramites'      => ['label' => 'Tipo de Trámites',  'icon' => 'tag'],
        'profile'            => ['label' => 'Mi Perfil',         'icon' => 'user'],
        'crear'              => ['label' => 'Crear',             'icon' => null],
        'mostrar'            => ['label' => 'Detalle',           'icon' => null],
        'editar'             => ['label' => 'Editar',            'icon' => null],
    ];

    $path  = trim(request()->path(), '/');
    $parts = explode('/', $path);
    $crumbs = [];

    if ($parts[0] !== 'dashboard') {
        $crumbs[] = ['label' => 'Inicio', 'url' => route('dashboard'), 'active' => false];
    }

    $built = '';
    foreach ($parts as $i => $part) {
        $built .= ($built ? '/' : '') . $part;
        $info  = $segments[$part] ?? ['label' => ucfirst(str_replace('-', ' ', $part)), 'icon' => null];
        $isLast = $i === array_key_last($parts);
        $crumbs[] = [
            'label'  => $info['label'],
            'url'    => url($built),
            'active' => $isLast,
        ];
    }
@endphp

@if (count($crumbs) > 0)
    <nav aria-label="Breadcrumb" class="hidden sm:flex items-center gap-1 text-sm">
        @foreach ($crumbs as $i => $crumb)
            @if (!$loop->first)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 shrink-0">
                    <path fill-rule="evenodd"
                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>
            @endif

            @if ($crumb['active'])
                <span class="font-semibold text-gray-700 dark:text-gray-200 truncate max-w-[180px]">
                    {{ $crumb['label'] }}
                </span>
            @else
                <a href="{{ $crumb['url'] }}" wire:navigate
                    class="text-gray-400 dark:text-gray-500 hover:text-brand-600 dark:hover:text-brand-400 transition-colors duration-150 truncate max-w-[140px]">
                    {{ $crumb['label'] }}
                </a>
            @endif
        @endforeach
    </nav>
@endif
