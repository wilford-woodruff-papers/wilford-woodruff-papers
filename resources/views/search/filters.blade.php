<nav class="flex flex-col flex-1"
     id="{{ $location }}-filters"
>
    <ul role="list"
        class="flex flex-col flex-1 gap-y-7"
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
                                    <div class="flex flex-1 gap-x-4 justify-between items-center">
                                        <div>{{ str($facet->name)->before('_facet')->title()->replace('_', ' ') }}</div>
                                        <div class="pr-4">
                                            @if(! empty($facet->tips()))
                                                <div x-data="{
popoverOpen: false,
popoverArrow: true,
popoverPosition: 'bottom',
popoverHeight: 0,
popoverOffset: 8,
popoverHeightCalculate() {
this.$refs.popover.classList.add('invisible');
this.popoverOpen=true;
let that=this;
$nextTick(function(){
that.popoverHeight = that.$refs.popover.offsetHeight;
that.popoverOpen=false;
that.$refs.popover.classList.remove('invisible');
that.$refs.popoverInner.setAttribute('x-transition', '');
that.popoverPositionCalculate();
});
},
popoverPositionCalculate(){
if(window.innerHeight < (this.$refs.popoverButton.getBoundingClientRect().top + this.$refs.popoverButton.offsetHeight + this.popoverOffset + this.popoverHeight)){
this.popoverPosition = 'top';
} else {
this.popoverPosition = 'bottom';
}
}
}"
                                                     x-init="
that = this;
window.addEventListener('resize', function(){
popoverPositionCalculate();
});
$watch('popoverOpen', function(value){
if(value){ popoverPositionCalculate(); document.getElementById('width').focus(); }
});

"
                                                     class="relative z-[11]">
                                                    <div role="button"
                                                         x-ref="popoverButton"
                                                         x-on:mouseover="popoverOpen=true"
                                                         x-on:mouseout="popoverOpen=false"
                                                         @click.stop="popoverOpen=!popoverOpen"
                                                         class="flex justify-center items-center w-8 h-8 bg-white rounded-full cursor-pointer hover:text-white focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:outline-none active:text-white border-neutral-200/70 hover:bg-primary active:bg-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 opacity-70">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                        </svg>
                                                    </div>
                                                    <div x-ref="popover"
                                                         x-show="popoverOpen"
                                                         x-init="setTimeout(function(){ popoverHeightCalculate(); }, 100);"
                                                         x-trap.inert="popoverOpen"
                                                         @click.away="popoverOpen=false;"
                                                         @keydown.escape.window="popoverOpen=false"
                                                         :class="{ 'top-0 mt-12' : popoverPosition == 'bottom', 'bottom-0 mb-12' : popoverPosition == 'top' }"
                                                         class="absolute left-1/2 max-w-lg -translate-x-1/2 w-[400px]" x-cloak>
                                                        <div x-ref="popoverInner" x-show="popoverOpen" class="p-4 w-full bg-white rounded-md border shadow-sm border-neutral-200/70">
                                                            <div x-show="popoverArrow && popoverPosition == 'bottom'" class="inline-block overflow-hidden absolute top-0 left-1/2 mt-px w-5 -translate-x-2 -translate-y-2.5"><div class="w-2.5 h-2.5 bg-white rounded-sm border-t border-l transform origin-bottom-left rotate-45"></div></div>
                                                            <div x-show="popoverArrow && popoverPosition == 'top'" class="inline-block overflow-hidden absolute bottom-0 left-1/2 mb-px w-5 -translate-x-2 translate-y-2.5"><div class="w-2.5 h-2.5 bg-white rounded-sm border-b border-l transform origin-top-left -rotate-45"></div></div>
                                                            <div>
                                                                {!! $facet->tips() !!}
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
