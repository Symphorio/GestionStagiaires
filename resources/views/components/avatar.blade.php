@props(['size' => '10'])

<div {{ $attributes->merge(['class' => "relative flex h-$size w-$size shrink-0 overflow-hidden rounded-full"]) }}>
    {{ $slot }}
</div>