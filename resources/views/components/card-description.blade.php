@props(['class' => ''])

<p {{ $attributes->merge(['class' => "text-sm text-gray-500 $class"]) }}>
    {{ $slot }}
</p>