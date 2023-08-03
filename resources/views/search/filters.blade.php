<nav class="flex flex-col flex-1"
     id="{{ $location }}-filters"
>
    <ul role="list"
        class="flex flex-col flex-1 gap-y-7 min-h-screen"
        x-cloak
    >
        @foreach($facets as $facet)
            @if($facet->display && array_key_exists($facet->key, $facetDistribution))
                <li x-data="{ expanded: $persist(true).as('{{ $facet->key }}_expanded') }">
                    <ul role="list" class="space-y-1">
                        <li>
                            <div>
                                <button x-on:click="expanded = ! expanded"
                                        type="button"
                                        class="flex gap-x-3 items-center py-2 w-full text-base font-semibold leading-6 text-left text-gray-700 rounded-md hover:bg-gray-50"
                                        aria-controls="sub-menu-{{ $facet->key }}"
                                        aria-expanded="false"
                                        x-bind:aria-expanded="expanded.toString()">
                                    <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                                    <svg class="w-5 h-5 text-gray-400 shrink-0"
                                         viewBox="0 0 20 20"
                                         fill="currentColor"
                                         aria-hidden="true"
                                         :class="{ 'rotate-90 text-gray-500': expanded, 'text-gray-400': !(expanded) }"
                                    >
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                    {{ str($facet->name)->before('_facet')->title()->replace('_', ' ') }}
                                </button>
                                <!-- Expandable link section, show/hide based on state. -->
                                <ul  x-show="expanded"
                                     x-collapse.duration.300ms
                                     x-cloak
                                     class="overflow-x-hidden overflow-y-scroll px-2 mt-1 max-h-80"
                                     id="{{ $location }}_sub-menu-{{ $facet->key }}"
                                >
                                    @foreach($facetDistribution[$facet->key] as $key => $value)
                                        <li
                                            class="pl-4 cursor-pointer"
                                            id="{{ $location }}_list_item_{{ str($facet->key) }}_{{ str($key)->snake() }}"
                                        >
                                            <div class="flex relative gap-x-1 items-center">
                                                <div class="flex items-center h-6 flex-0">
                                                    <input wire:model="filters.{{ str($facet->key)->before('_facet') }}"
                                                           id="{{ $location }}_{{ str($facet->key) }}_{{ str($key)->snake() }}"
                                                           name="{{ str($facet->key) }}"
                                                           type="checkbox"
                                                           value="{{ $key }}"
                                                           class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" />
                                                </div>
                                                <div class="overflow-hidden flex-1 text-sm leading-6">
                                                    <label for="{{ $location }}_{{ str($facet->key) }}_{{ str($key)->snake() }}"
                                                           class="flex-1 font-medium text-gray-900 cursor-pointer">
                                                        <div class="flex gap-x-2 justify-between py-1 pr-2 pl-2 text-sm leading-6 text-gray-700 rounded-md hover:bg-gray-50"
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
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                    </ul>
                </li>
            @endif
        @endforeach

        <li x-data="{ expanded: $persist(true).as('year_range_expanded') }">
            <ul x-show="currentIndex == 'Documents'"
                role="list"
                class="overflow-hidden space-y-1 h-32"
            >
                <li>
                    <div>
                        <button x-on:click="expanded = ! expanded"
                                type="button"
                                class="flex gap-x-3 items-center py-2 w-full text-base font-semibold leading-6 text-left text-gray-700 rounded-md hover:bg-gray-50"
                                aria-controls="sub-menu-year_range"
                                aria-expanded="false"
                                x-bind:aria-expanded="expanded.toString()">
                            <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                            <svg class="w-5 h-5 text-gray-400 shrink-0"
                                 viewBox="0 0 20 20"
                                 fill="currentColor"
                                 aria-hidden="true"
                                 :class="{ 'rotate-90 text-gray-500': expanded, 'text-gray-400': !(expanded) }"
                            >
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                            Year Range
                        </button>
                        <ul  x-show="expanded"
                             x-collapse.duration.300ms
                             x-cloak
                             class="px-2 mt-1 max-h-80"
                             id="{{ $location }}_sub-menu-year_range"
                        >
                            <div wire:ignore
                                 class="px-8 mt-2"
                            >
                                <div id="{{ $location }}_range" wire:model="year_range.min,year_range.max"></div>
                            </div>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        @if(isset($use_date_range))
            <li x-data="{
                                    expanded: $persist(@entangle('use_date_range')).as('date_range_expanded')
                                }">
                <ul x-show="currentIndex == 'Documents'"
                    role="list"
                    class="space-y-1"
                >
                    <li>
                        <div>
                            <button x-on:click="expanded = ! expanded"
                                    type="button"
                                    class="flex gap-x-3 items-center py-2 w-full text-base font-semibold leading-6 text-left text-gray-700 rounded-md hover:bg-gray-50"
                                    aria-controls="sub-menu-year_range"
                                    aria-expanded="false"
                                    x-bind:aria-expanded="expanded.toString()">
                                <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                                <svg class="w-5 h-5 text-gray-400 shrink-0"
                                     viewBox="0 0 20 20"
                                     fill="currentColor"
                                     aria-hidden="true"
                                     :class="{ 'rotate-90 text-gray-500': expanded, 'text-gray-400': !(expanded) }"
                                >
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                                Specific Date Range
                            </button>
                            <ul  x-show="expanded"
                                 x-collapse.duration.300ms
                                 x-cloak
                                 class="px-2 mt-1 max-h-80"
                                 id="{{ $location }}_sub-menu-year_range"
                            >
                                <div wire:ignore
                                     class="px-2 mt-2"
                                >
                                    <div
                                        x-data="{
                                                                value: '{{ $full_date_range['min']->format('m/d/Y') }}',
                                                                init() {
                                                                    let picker = flatpickr(this.$refs.picker, {
                                                                        dateFormat: 'm/d/Y',
                                                                        defaultDate: this.value,
                                                                        onChange: (date, dateString) => {
                                                                            this.value = dateString
                                                                        }
                                                                    })

                                                                    this.$watch('value', function(value) {
                                                                            picker.setDate(value);
                                                                            $wire.set('full_date_range.min', value);
                                                                        });

                                                                },
                                                            }"
                                        class="w-full max-w-sm"
                                    >
                                        <div class="mb-2 font-bold"></div>

                                        <input class="py-2.5 px-3 w-full border-0 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-secondary" x-ref="picker" type="text">
                                    </div>
                                    <div class="relative mt-2">
                                        <div class="flex absolute inset-0 items-center" aria-hidden="true">
                                            <div class="w-full border-t border-gray-300"></div>
                                        </div>
                                        <div class="flex relative justify-center">
                                            <span class="px-3 text-base font-semibold leading-6 text-gray-600 bg-white">to</span>
                                        </div>
                                    </div>
                                    <div
                                        x-data="{
                                                                value: '{{ $full_date_range['max']->format('m/d/Y') }}',
                                                                init() {
                                                                    let picker = flatpickr(this.$refs.picker, {
                                                                        dateFormat: 'm/d/Y',
                                                                        defaultDate: this.value,
                                                                        onChange: (date, dateString) => {
                                                                            this.value = dateString
                                                                        }
                                                                    })

                                                                    this.$watch('value', function(value) {
                                                                            picker.setDate(value);
                                                                            $wire.set('full_date_range.max', value);
                                                                        });
                                                                },
                                                            }"
                                        class="w-full max-w-sm"
                                    >
                                        <div class="mb-2 font-bold"></div>

                                        <input class="py-2.5 px-3 w-full border-0 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-secondary" x-ref="picker" type="text">
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
