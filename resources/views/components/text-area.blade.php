@props(['rows' => 4, 'name', 'value' => '', 'placeholder' => ''])

<textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full']) }}
>{{ old($name, $value) }}</textarea>
