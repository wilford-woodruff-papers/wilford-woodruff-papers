<label for="{{ $property->slug }}"
       class="block text-sm font-medium text-gray-700"
>
    <span class="font-semibold">{{ $property->name }}</span> ({{ str($property->type)->title() }})
</label>
{{--<input type="text"
       name="property_{{ $property->slug }}_{{ $property->id }}"
       id="{{ $property->slug }}"
       value="{{ $value?->value }}"
       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
>--}}

<div class="flex gap-x-2">
    <div class="flex-grow">
        <input type="text"
               name="property_{{ $property->slug }}_{{ $property->id }}"
               id="{{ $property->slug }}"
               value="{{ $value?->value }}"
               class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-sky-500 focus:ring-sky-500"
       >
    </div>
    @if(! empty($value?->value))
        <span class="ml-3">
            <a href="{{ $value?->value }}"
               target="_blank"
               class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </span>
    @endif
    @if(! empty($modelId) && empty($value?->value))
        <livewire:admin.single-action
            :actionTypeName="'Checked'"
            :actionTypeNamePrefix="'Mark'"
            :modelId="$modelId"
            :class="'Value'"
            :type="'Research'" />
    @endif
</div>
