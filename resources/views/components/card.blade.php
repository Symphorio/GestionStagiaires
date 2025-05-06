@props(['class' => ''])

<div {{ $attributes->merge(['class' => "rounded-lg border bg-white text-gray-900 shadow-sm $class"]) }}>
    {{ $slot }}
</div>