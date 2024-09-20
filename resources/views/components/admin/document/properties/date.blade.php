<label for="{{ $property->slug }}"
       class="block text-sm font-medium text-gray-700"
>
    <span class="font-semibold">{{ $property->name }}</span> ({{ str($property->type)->title() }}) @if($property->required) <span class="text-red-600">*</span> @endif
</label>
<div class="flex gap-x-2">
    <input type="date"
           name="property_{{ $property->slug }}_{{ $property->id }}"
           id="{{ $property->slug }}"
           value="{{ $value?->value }}"
           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
           @readonly($property->readonly)
    @required($property->required)
    >
    @if(! empty($modelId) && empty($value?->value))
        <livewire:admin.single-action
            :actionTypeName="'Checked'"
            :actionTypeNamePrefix="'Mark'"
            :modelId="$modelId"
            :class="'Value'"
            :type="'Research'" />
    @endif
</div>
