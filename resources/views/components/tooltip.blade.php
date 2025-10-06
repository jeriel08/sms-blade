@props([
    'text' => '',
    'position' => 'top', // top, bottom, left, right
])

<div class="relative flex items-center justify-center group" x-data="{ show: false }">
    <div 
        @mouseenter="show = true" 
        @mouseleave="show = false"
        {{ $attributes->whereDoesntStartWith('class') }}
    >
        {{ $slot }}
    </div>
    
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-md shadow-sm whitespace-nowrap
               @switch($position)
                   @case('top')
                       -top-8 left-1/2 transform -translate-x-1/2
                       @break
                   @case('bottom')
                       -bottom-8 left-1/2 transform -translate-x-1/2
                       @break
                   @case('left')
                       -left-2 top-1/2 transform -translate-y-1/2 -translate-x-full
                       @break
                   @case('right')
                       -right-2 top-1/2 transform -translate-y-1/2 translate-x-full
                       @break
                   @default
                       -top-8 left-1/2 transform -translate-x-1/2
               @endswitch"
        style="display: none;"
    >
        {{ $text }}
        <div class="@switch($position)
            @case('top')
                absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900
                @break
            @case('bottom')
                absolute bottom-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-b-gray-900
                @break
            @case('left')
                absolute left-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-l-gray-900
                @break
            @case('right')
                absolute right-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-r-gray-900
                @break
            @default
                absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900
        @endswitch"></div>
    </div>
</div>