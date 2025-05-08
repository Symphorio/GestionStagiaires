@props(['type' => 'text'])

<input 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => 'flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-supervisor focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm']) }}
>