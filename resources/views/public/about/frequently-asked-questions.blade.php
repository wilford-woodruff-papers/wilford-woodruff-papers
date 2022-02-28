<x-guest-layout>
    <div id="content" role="main"
         x-data="{
                openPanel: 'mission'
            }"
    >
        <div class="max-w-7xl mx-auto px-4">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="About"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <div class="content max-w-5xl mx-auto ">
                            <h2>Frequently Asked Questions</h2>
                            <div class="mt-6 mb-12 space-y-6 divide-y divide-gray-200">
                                <div class="pt-6">
                                    <div class="text-lg">
                                        <!-- Expand/collapse question button -->
                                        <button aria-expanded="true"
                                                class="text-left w-full flex justify-between items-start text-gray-400"
                                                x-bind:aria-expanded="openPanel === 'mission'"
                                                x-description="Expand/collapse question button"
                                                x-on:click="openPanel = (openPanel === 'mission' ? null : 'mission')">
                                        <span class="font-medium text-gray-900">
                                            What is the purpose of the Wilford Woodruff Papers Project?
                                        </span>
                                            <span class="ml-6 h-7 flex items-center">
                                        <!--
                                          Heroicon name: outline/chevron-down

                                          Open: "-rotate-180", Closed: "rotate-0"
                                        -->
                                        <svg aria-hidiven="true" class="-rotate-180 h-6 w-6 transform" fill="none" stroke="currentColor" viewbox="0 0 24 24" x-bind:class="{ '-rotate-180': openPanel === 'mission', 'rotate-0': !(openPanel === 'mission') }"
                                             x-state:off="Closed"
                                             x-state:on="Open" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-widivh="2"></path> </svg> </span>
                                        </button></div>

                                    <div class="mt-2 pr-12" x-show="openPanel === 'mission'">
                                        <p class="text-base text-gray-500">
                                            <x-mission-statement />
                                        </p>
                                    </div>
                                </div>
                                @foreach($faqs as $key => $faq)
                                    <div class="pt-6">
                                        <div class="text-lg">
                                            <!-- Expand/collapse question button -->
                                            <button aria-expanded="true"
                                                    class="text-left w-full flex justify-between items-start text-gray-400"
                                                    x-bind:aria-expanded="openPanel === {{ $key }}"
                                                    x-description="Expand/collapse question button"
                                                    x-on:click="openPanel = (openPanel === {{ $key }} ? null : {{ $key }})">
                                        <span class="font-medium text-gray-900">
                                            {{ $faq->question }}
                                        </span>
                                                <span class="ml-6 h-7 flex items-center">
                                        <!--
                                          Heroicon name: outline/chevron-down

                                          Open: "-rotate-180", Closed: "rotate-0"
                                        -->
                                        <svg aria-hidiven="true" class="-rotate-180 h-6 w-6 transform" fill="none" stroke="currentColor" viewbox="0 0 24 24" x-bind:class="{ '-rotate-180': openPanel === {{ $key }}, 'rotate-0': !(openPanel === {{ $key }}) }"
                                             x-state:off="Closed"
                                             x-state:on="Open" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-widivh="2"></path> </svg> </span>
                                            </button></div>

                                        <div class="mt-2 pr-12" x-show="openPanel === {{ $key }}">
                                            <p class="text-base text-gray-500">
                                                {!! $faq->answer !!}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
