<ul  x-show="expanded"
     x-collapse.duration.300ms
     x-cloak
     class="overflow-y-auto overflow-x-hidden px-2 mt-1 max-h-80"
     id="{{ $location }}_sub-menu-{{ $facet->key }}"
>
    @foreach($facet->sort($facetDistribution[$facet->key]) as $key => $value)
        @if(
            (empty($filters['volumes']))
            || (in_array($volumeMap[getVolume($key)], $filters['volumes']))
        )
            <li
                class="pl-4 cursor-pointer"
                id="{{ $location }}_list_item_{{ str($facet->key) }}_{{ str($key)->snake() }}"
            >
                <div class="flex relative gap-x-1 items-center">
                    <div class="flex items-center h-6 flex-0">
                        <input wire:model.live="filters.{{ str($facet->key)->before('_facet') }}"
                               id="{{ $location }}_{{ str($facet->key) }}_{{ str($key)->snake() }}"
                               name="{{ str($facet->key) }}"
                               type="checkbox"
                               value="{{ $key }}"
                               class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary" />
                    </div>
                    <div class="overflow-hidden flex-1 text-sm leading-6">
                        <label for="{{ $location }}_{{ str($facet->key) }}_{{ str($key)->snake() }}"
                               class="flex-1 font-medium text-gray-900 cursor-pointer">
                            <div class="flex gap-x-2 justify-between py-1 pr-2 pl-2 text-sm leading-6 text-gray-700 hover:bg-gray-50"
                            >
                                <div class="flex gap-2 items-center truncate">
                                    @if($facet->key == 'resource_type')
                                        @includeFirst(['search.'.str($key)->snake(), 'search.generic'])
                                    @elseif($currentIndex == 'Media' && $facet->key == 'type')
                                        @includeFirst(['search.'.str($key)->snake(), 'search.generic'])
                                    @endif
                                    {{ $key }}
                                </div>
                                <span>({{ number_format($value, 0, ',') }})</span>
                            </div>
                        </label>
                    </div>
                </div>
            </li>
        @endif

    @endforeach
</ul>
