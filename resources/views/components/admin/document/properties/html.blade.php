<label for="{{ $property->slug }}"
       class="block text-sm font-medium text-gray-700"
>
    <span class="font-semibold">{{ $property->name }}</span> ({{ str($property->type)->upper() }})
</label>
<textarea name="property_{{ $property->slug }}_{{ $property->id }}"
       id="{{ $property->slug }}"
       class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-sky-500 sm:text-sm"
>{!! $value?->value !!}</textarea>
