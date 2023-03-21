@if($link = $model->values->where('property.name', $value?->property?->name.' Link')->first())
    <a href="{{ $link?->value }}"
       class="text-secondary"
       target="_blank"
       title="{{ $value?->value }}"
    >
        {{ str($value?->value)->limit(40, '...')->after('//')->before('/') }}
    </a>
@else
    <div title="{{ strip_tags($value?->value) }}">
        {{ str($value?->value)->limit(40, '...') }}
    </div>
@endif
