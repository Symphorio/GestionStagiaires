@props(['title', 'value', 'description', 'icon', 'color'])

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full {{ $color }} mr-4">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
        </div>
    </div>
    <p class="text-xs text-gray-500 mt-2">{{ $description }}</p>
</div>