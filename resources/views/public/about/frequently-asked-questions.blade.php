<x-guest-layout>
    <x-slot name="title">
        Frequently Asked Questions | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main"
         x-data="{ active: 0 }"
    >
        <div class="max-w-7xl mx-auto px-4">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="About"/>
                    </div>
                    <div class="faq col-span-12 md:col-span-9">
                        <div class="max-w-5xl mx-auto ">
                            <div class="content">
                                <h2>Frequently Asked Questions</h2>
                            </div>
                            <div class="mt-0 mb-12 divide-y divide-gray-200">

                                @php
                                    $categories = ['Project', 'Documents', 'Funding'];
                                    $faqsGroupedByCategory = $faqs->groupBy('category');
                                @endphp

                                @foreach($categories as $category)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 py-8">
                                        <div class="font-extrabold">
                                            <h2 class="text-3xl uppercase pb-1 border-b-4 border-highlight">{{ $category }}</h2>
                                        </div>
                                    </div>

                                    @foreach($faqsGroupedByCategory[$category]->all() as $key => $faq)

                                        @if($category == 'Project' && $loop->first)
                                            <div x-data="{
                                        id: 0,
                                        get expanded() {
                                            return this.active === this.id
                                        },
                                        set expanded(value) {
                                            this.active = value ? this.id : null
                                        },
                                    }"
                                                 role="region"
                                                 class="">
                                                <div class="text-lg py-4 border-l-4 border-white pl-2"
                                                     x-bind:class="{ 'bg-gray-200 border-secondary': active === 0, 'bg-white border-white': !(active === 0) }">
                                                    <!-- Expand/collapse question button -->
                                                    <button aria-expanded="true"
                                                            class="text-left w-full flex items-start text-gray-400"
                                                            x-description="Expand/collapse question button"
                                                            x-on:click="expanded = !expanded"
                                                            :aria-expanded="expanded">
                                            <span class="mr-4 h-7 flex items-center">
                                                <!--
                                                  Heroicon name: outline/chevron-down

                                                  Open: "-rotate-180", Closed: "rotate-0"
                                                -->
                                                <svg aria-hidiven="true" class="-rotate-180 h-6 w-6 transform" fill="none" stroke="currentColor" viewbox="0 0 24 24" x-bind:class="{ 'rotate-0 text-secondary': active === 0, '-rotate-90': !(active === 0) }"
                                                     x-state:off="Closed"
                                                     x-state:on="Open" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-widivh="2"></path>
                                                </svg>
                                            </span>
                                                        <span class="font-semibold text-gray-900">
                                                What is the purpose of the Wilford Woodruff Papers Project?
                                            </span>
                                                    </button>
                                                </div>

                                                <div class="pr-12 pl-12 text-primary text-gray-500"
                                                     x-show="expanded"
                                                     x-collapse
                                                >
                                                    <x-mission-statement />
                                                </div>
                                            </div>
                                        @endif

                                        <div x-data="{
                                            id: {{ $faq->id }},
                                            get expanded() {
                                                return this.active === this.id
                                            },
                                            set expanded(value) {
                                                this.active = value ? this.id : null
                                            },
                                        }"
                                             role="region"
                                             class="">
                                            <div class="text-lg py-4 border-l-4 border-white pl-2"
                                                 x-bind:class="{ 'bg-gray-200 border-secondary': active === {{ $faq->id }}, 'bg-white border-white': !(active === {{ $faq->id }}) }"
                                            >
                                                <!-- Expand/collapse question button -->
                                                <button aria-expanded="true"
                                                        class="text-left w-full flex items-start text-gray-400"
                                                        x-description="Expand/collapse question button"
                                                        x-on:click="expanded = !expanded"
                                                        :aria-expanded="expanded">
                                                <span class="mr-4 h-7 flex items-center">
                                                    <!--
                                                      Heroicon name: outline/chevron-down

                                                      Open: "-rotate-180", Closed: "rotate-0"
                                                    -->
                                                    <svg aria-hidiven="true" class="-rotate-180 h-6 w-6 transform" fill="none" stroke="currentColor" viewbox="0 0 24 24"    x-bind:class="{ 'rotate-0 text-secondary': active === {{ $faq->id }}, '-rotate-90': !(active === {{ $faq->id }}) }"
                                                         x-state:off="Closed"
                                                         x-state:on="Open" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-widivh="2"></path>
                                                    </svg>
                                                </span>
                                                    <span class="text-primary text-lg font-semibold">
                                                    {{ $faq->question }}
                                                </span>
                                                </button>
                                            </div>

                                            <div class="py-4 pr-12 pl-12 text-primary text-lg"
                                                 x-show="expanded"
                                                 x-collapse
                                                 x-cloak
                                            >
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach




                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
