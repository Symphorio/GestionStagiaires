@props([
    'value' => 0,
    'class' => ''
])

<div 
    {{ $attributes->merge(['class' => "relative h-4 w-full overflow-hidden rounded-full bg-gray-200 $class"]) }}
    role="progressbar"
    aria-valuenow="{{ $value }}"
    aria-valuemin="0"
    aria-valuemax="100"
>
    <div 
        class="h-full w-full flex-1 bg-blue-600 transition-all" 
        style="width: {{ $value }}%"
    ></div>
</div>