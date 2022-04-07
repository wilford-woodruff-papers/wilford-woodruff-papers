<a
    {{ $attributes->merge([
        'target' => ($attributes->get('target') ? $attributes->get('target') : '_self'),
        'class' => 'font-semibold text-center px-6 py-3',
    ]) }}
>
    {{ $slot }}
</a>
