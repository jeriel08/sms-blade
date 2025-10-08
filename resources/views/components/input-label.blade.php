@props(['value', 'important' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
    @if($important)
        <span class="text-red-500">*</span>
    @endif
</label>