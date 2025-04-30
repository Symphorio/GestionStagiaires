@props(['href', 'icon'])

<a href="{{ $href }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    @if($icon)
        <i class="{{ $icon }} mr-3 text-gray-500"></i>
    @endif
    <span>{{ $slot }}</span>
</a>