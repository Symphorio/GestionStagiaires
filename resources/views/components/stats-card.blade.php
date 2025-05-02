@props([
    'title' => '',
    'value' => '',
    'description' => '',
    'icon' => 'chart-bar',
    'color' => 'bg-blue-100 text-blue-600'
])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
    <div class="p-6">
        <div class="flex items-start">
            <div class="p-3 rounded-lg {{ $color }} mr-4 shadow-inner">
                <i class="fas fa-{{ $icon }} text-lg"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $title }}</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $value }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $description }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
        <div class="text-xs font-medium text-gray-500 flex items-center">
            <i class="fas fa-info-circle mr-1"></i>
            <span>Mis à jour à {{ now()->format('H:i') }}</span>
        </div>
    </div>
</div>