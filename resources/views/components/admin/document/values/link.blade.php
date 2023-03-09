<a href="{{ $value?->value }}"
   class="text-secondary"
   target="_blank"
>
    @if($label = $model->values->where('property.name', str($value?->property?->name)->before(' Link'))->first())
        {{ $label->value }}
    @else
        {{ $value?->value }}
    @endif
</a>
