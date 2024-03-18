<label for="{{ $property->slug }}"
       class="block text-sm font-medium text-gray-700"
>
    <span class="font-semibold">{{ $property->name }}</span> ({{ str($property->type)->title() }})
</label>

<div class="flex gap-x-2">
    <select name="property_{{ $property->slug }}_{{ $property->id }}"
            id="{{ $property->slug }}"
            class="block py-2 px-3 mt-2 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500">
        <option value="">
            -- Select a {{ str($property->name)->title() }} --
        </option>
        @php
            $model = "App\\Models\\$property->relationship";
            $options = $model::query()->orderBy('name')->get();
        @endphp
        @foreach($options as $option)
            <option value="{{ $option->id }}"
                   @selected($option->id == old('country', $value?->value))
            >
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>
