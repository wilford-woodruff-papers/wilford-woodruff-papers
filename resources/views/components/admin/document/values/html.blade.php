<div title="{{ strip_tags($value?->value) }}">
    {{ str($value?->value)->limit(40, '...') }}
</div>

