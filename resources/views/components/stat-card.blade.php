@props([
    'title',
    'value',
    'description',
    'icon'
])

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold mt-1">{{ $value }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $description }}</p>
        </div>
        <div class="bg-blue-100 rounded-full p-3 text-blue-600">
            <span class="text-xl">{{ $icon }}</span>
        </div>
    </div>
</div>