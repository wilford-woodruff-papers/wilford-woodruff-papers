<x-link href=""
    {{ $attributes->merge([
        'class' => 'bg-highlight text-white uppercase',
    ]) }}
>
    {{ $slot }}
</x-link>
