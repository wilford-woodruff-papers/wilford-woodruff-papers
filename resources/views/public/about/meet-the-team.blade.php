<x-guest-layout>
    <x-slot name="title">
        Meet the Team | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="bg-gradient-to-b from-secondary to-secondary-300 px-4 md:px-0">
            <div class="max-w-7xl mx-auto pt-24 pb-12">
                <div class="grid grid-cols-12 gap-x-8">
                    <div class="col-span-12 md:col-span-3"></div>
                    <div class="col-span-12 md:col-span-9">
                        <h1 class="text-5xl text-white">Meet the Team</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12 gap-x-8">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="About"/>
                    </div>
                    <div class="col-span-12 md:col-span-9">
                        <div class="grid grid-cols-1 gap-x-4 mb-12">
                            @foreach($teams as $team)
                                @if($team->boardmembers->count() > 0)
                                    @if($team->name != 'Interns & Volunteers')
                                        <div x-data="{
                                                show: {{ $team->expanded }},
                                            }"
                                             role="region">
                                            <div class="max-w-7xl mx-auto px-12 mt-4 mb-12">
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
                                                            class="flex w-full items-center"
                                                        >
                                                            <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">
                                                                {{ $team->name }}
                                                            </h3>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul x-show="show"
                                                x-collapse
                                                role="list" class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-4 lg:gap-x-8 mb-16">
                                                @foreach($team->boardmembers as $person)
                                                    <li x-data="{
                                                            show: false,
                                                        }"
                                                        onclick="Livewire.emit('openModal', 'team-member-modal', {{ json_encode(["person" => $person->id, 'backgroundColor' => $team->background_color, 'textColor' => $team->text_color]) }})"
                                                        class="group relative rounded-xl"
                                                        style="background-color: {{ $team->background_color }}; color: {{ $team->text_color }};"
                                                    >
                                                        <div class="space-y-4 cursor-pointer">
                                                            <div class="pt-5 px-7">
                                                                <div class="aspect-w-3 aspect-h-4">
                                                                    <img class="object-cover object-top" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                                </div>
                                                            </div>

                                                            <div class="space-y-2 pb-2">
                                                                <div class="space-y-1 text-base font-medium leading-6 text-center px-1">
                                                                    <h3 class="font-semibold">{{ $person->name }}</h3>
                                                                    @if(! empty($person->title))
                                                                        <p class="serif px-4">
                                                                            {{ $person->title }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @elseif($team->name == 'Interns & Volunteers')
                                        <div x-data="{
                                                show: {{ $team->expanded }},
                                            }"
                                             role="region">
                                            <div class="max-w-7xl mx-auto px-12 mt-4 mb-12">
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
                                                            class="flex w-full items-center"
                                                        >
                                                            <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">
                                                                {{ $team->name }}
                                                            </h3>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div x-show="show"
                                                x-collapse
                                                class="grid grid-cols-10 mb-16">
                                                @foreach($team->boardmembers->shuffle() as $person)
                                                    <div class="flex">
                                                        <img class="object-cover object-top object-center aspect-[3/4]" src="{{ Storage::disk('board_members')->url($person->image) }}" alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        {{--<div>
                            <div class="h-16 mt-4 mb-12">
                                <div class="max-w-7xl mx-auto px-12">
                                    <div class="py-4 border-b-2 border-[#707070]">
                                        <h3 class="font-serif text-xl md:text-2xl leading-5 font-medium text-black font-medium">Volunteers</h3>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('img/about/volunteers.png') }}"
                                     alt=""
                                     class="w-full h-auto"
                                />
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
