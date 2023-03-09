@if($label = $model->values->where('property.name', $value?->property?->name.' Link')->first())
    <a href="{{ $value?->value }}"
       class="text-secondary"
       target="_blank"
    >
    {{ $value->value }}
    </a>
@else
    {{ $value?->value }}
@endif
