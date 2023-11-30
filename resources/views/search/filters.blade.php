<nav class="flex flex-col flex-1"
     id="{{ $location }}-filters"
>
    <ul role="list"
        class="flex flex-col flex-1 gap-y-7"
        x-cloak
    >
        @foreach($facets as $facet)
            @if($facet->display && array_key_exists($facet->key, $facetDistribution))
                <li x-data="{
                    expanded: $persist(true).as('{{ $facet->key }}_expanded'),
                    open: false,
                }"
                    x-init="$watch('open', value => {
                        if(value === true) {
                            document.getElementById('context-header').classList.toggle('z-50');
                            document.getElementById('context-header').classList.toggle('z-11');
                        } else {
                            document.getElementById('context-header').classList.toggle('z-11');
                            document.getElementById('context-header').classList.toggle('z-50')
                        }
                    })"
                >
                    <ul role="list" class="space-y-1">
                        <li>
                            <div>
                                <button
                                        type="button"
                                        class="flex gap-x-3 items-center py-2 w-full text-base font-semibold leading-6 text-left text-gray-700 rounded-md hover:bg-gray-50"
                                        aria-controls="sub-menu-{{ $facet->key }}"
                                        aria-expanded="false"
                                        x-bind:aria-expanded="expanded.toString()">
                                    <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                                    <svg  x-on:click="expanded = ! expanded"
                                          class="w-5 h-5 text-gray-400 shrink-0"
                                         viewBox="0 0 20 20"
                                         fill="currentColor"
                                         aria-hidden="true"
                                         :class="{ 'rotate-90 text-gray-500': expanded, 'text-gray-400': !(expanded) }"
                                    >
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-1 gap-x-4 justify-between items-center z-[200]">
                                        <div x-on:click="expanded = ! expanded" class="flex-1">{{ str($facet->name)->before('_facet')->title()->replace('_', ' ') }}</div>
                                        <div class="pr-0 z-[200]">
                                            @if(! empty($facet->tips()))

                                                <div class="flex justify-center">
                                                    <!-- Trigger -->
                                                    <div x-on:click.stop="open = true"
                                                         class="z-[200]"
                                                    >
                                                        <div role="button"
                                                             class="flex justify-center items-center w-8 h-8 bg-white rounded-full cursor-pointer hover:text-white focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:outline-none active:text-white border-neutral-200/70 hover:bg-primary active:bg-primary"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 opacity-70">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div
                                                        x-dialog
                                                        x-model="open"
                                                        style="display: none"
                                                        class="overflow-y-auto fixed inset-0 z-[200]"
                                                    >
                                                        <!-- Overlay -->
                                                        <div x-dialog:overlay x-transition.opacity class="fixed inset-0 bg-black bg-opacity-70"></div>

                                                        <!-- Panel -->
                                                        <div
                                                            class="flex relative justify-center items-center p-4 min-h-screen"
                                                        >
                                                            <div
                                                                x-dialog:panel
                                                                x-transition
                                                                class="overflow-y-auto relative w-full max-w-xl bg-white rounded-xl shadow-lg"
                                                            >
                                                                <!-- Close Button -->
                                                                <div class="absolute top-0 right-0 pt-4 pr-4">
                                                                    <div role="button" @click="$dialog.close()" class="p-2 text-gray-600 bg-gray-50 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                                                        <span class="sr-only">Close modal</span>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                        </svg>
                                                                    </div>
                                                                </div>

                                                                <!-- Body -->
                                                                <div class="p-8">
                                                                    <!-- Title -->
                                                                    <h2 x-dialog:title class="text-2xl font-bold">Descriptions</h2>
                                                                    <!-- Content -->
                                                                    <div class="mt-3 text-gray-600">
                                                                        {!! $facet->tips() !!}
                                                                    </div>
                                                                </div>

                                                                <!-- Footer -->
                                                                <div class="flex justify-end p-4 space-x-2 bg-gray-50">
                                                                    <div role="button" x-on:click="$dialog.close()" class="py-2.5 px-5 text-gray-600 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                                                        Close
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                                <!-- Expandable link section, show/hide based on state. -->
                                <ul  x-show="expanded"
                                     x-collapse.duration.300ms
                                     x-cloak
                                     class="overflow-x-hidden overflow-y-scroll px-2 mt-1 max-h-80"
                                     id="{{ $location }}_sub-menu-{{ $facet->key }}"
                                >
                                    @foreach($facet->sort($facetDistribution[$facet->key]) as $key => $value)
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

        <li x-data="{
            expanded: $persist(true).as('year_range_expanded')
        }">
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
                                <div id="{{ $location }}_range" wire:model.live="year_range.min,year_range.max"></div>
                            </div>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        @if(isset($use_date_range))
            <li x-data="{
                expanded: $persist(@entangle('use_date_range').live).as('date_range_expanded')
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
