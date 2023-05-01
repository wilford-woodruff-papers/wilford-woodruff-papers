<a href="{{ $value?->value }}"
   class="text-secondary"
   target="_blank"
   title="{{ $value?->value }}"
>
    @if($label = $model->values->where('property.name', str($value?->property?->name)->before(' Link'))->first())
        {{ str($label?->value)->after('//')->before('/') }}
    @else
        {{ str($value?->value)->after('//')->before('/') }}
    @endif
</a>
