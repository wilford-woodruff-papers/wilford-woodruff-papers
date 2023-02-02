<x-guest-layout>
    <x-slot name="title">
        Partners | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 bg-gradient-to-b md:px-0 from-secondary to-secondary-300">
            <div class="pt-24 pb-12 mx-auto max-w-7xl">
                <div class="grid grid-cols-12 gap-x-8">
                    <div class="col-span-12 md:col-span-3"></div>
                    <div class="col-span-12 md:col-span-9">
                        <h1 class="text-5xl text-white">Partners</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 gap-x-8 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="About"/>
                    </div>
                    <div class="col-span-12 md:col-span-9">
                        <div class="grid grid-cols-1 gap-x-4 mb-12">
                            @foreach($partnerCategories as $key => $partnerCategory)
                                @if($partnerCategory->count() > 0)
                                    <div x-data="{
                                            show: true,
                                        }"
                                         role="region">
                                        <div class="px-12 mx-auto mt-4 mb-4 max-w-7xl">
                                            <div class="flex items-center border-b-2 border-[#707070] ">
                                                <div x-on:click="show = !show"
                                                     class="flex items-center py-4 cursor-pointer">
                                                    <span x-show="show" aria-hidden="true" class="-ml-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </span>
                                                    <span x-show="!show" aria-hidden="true" class="-ml-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                        </svg>

                                                    </span>
                                                </div>
                                                <div class="py-4">
                                                    <button
                                                        x-on:click="show = !show"
                                                        :aria-expanded="show"
                                                        class="flex items-center w-full"
                                                    >
                                                        <h3 class="font-serif text-xl font-medium leading-5 text-black md:text-2xl">
                                                            {{ $partnerCategory->name }}
                                                        </h3>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="show"
                                             x-collapse
                                             class="px-4 mb-12 text-lg text-justify text-primary">
                                            {!! $partnerCategory->description !!}
                                        </div>
                                        <ul x-show="show"
                                            x-collapse
                                            role="list" class="mb-16 space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-4 lg:gap-x-8">
                                            @foreach($partnerCategory->partners as $partner)
                                                <li class="flex justify-center items-center">
                                                    <a href="{{ $partner->url }}"
                                                       target="_blank"
                                                    >
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('partners')->url($partner->logo ?? '') }}"
                                                             alt="{{ $partner->name }} Logo"
                                                             title="{{ $partner->name }}"
                                                        />
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
