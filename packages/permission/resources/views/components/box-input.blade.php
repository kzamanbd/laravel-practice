@props(['disabled' => false, 'type' => 'checkbox'])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'type' => $type,
    'class' =>
        'w-4 h-4 text-primary bg-gray-100 rounded border-gray-300 focus:ring-primary/50 dark:focus:ring-primary/60 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600',
]) !!}>
