@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 focus:border-primary-500 dark:focus:border-primary-400 focus:outline-none focus:ring-primary-500 rounded-md shadow-sm form-input',
]) !!}>
