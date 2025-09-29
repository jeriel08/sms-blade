@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-3 bg-blue-50 border-l-4 border-1 text-sm font-medium text-1 focus:outline-hidden transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-3 border-l-4 border-transparent text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-hidden transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>