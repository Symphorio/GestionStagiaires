@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'flex h-full w-full items-center justify-center rounded-full bg-gray-100 ' . $class]) }}>
    {{ $slot }}
</div>