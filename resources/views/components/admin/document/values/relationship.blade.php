<div title="{{ strip_tags($value?->value) }}">
    {{ $value?->{str($value?->property->relationship)->lower()}?->name }}
</div>

{{-- Display relationship name in table layout rather than id --}}
