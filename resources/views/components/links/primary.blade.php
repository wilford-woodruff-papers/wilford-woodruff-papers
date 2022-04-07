<x-link href=""
    {{ $attributes->merge([
        'class' => 'bg-secondary text-white',
    ]) }}
>
    {{ $slot }}
</x-link>
